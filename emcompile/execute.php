<!DOCTYPE html>
<?php
require_once("../tsugi/config.php");
require_once("util.php");

// global $CFG;

$code = $_POST['code'] ?? '';
$secret = $_POST['secret'] ?? '';
$input = $_POST['input'] ?? '';
if ( strlen($code) < 1 ) die('Need code');
if ( strlen($code) > 100000 ) die ('Need less code');
if ( strlen($secret) < 1 || $CFG->getExtension('emscripten_secret') != $secret ) die("Bletchley Park");

function tempdir() {
    $tempfile=tempnam(sys_get_temp_dir(),'');
    // tempnam creates file on disk
    if (file_exists($tempfile)) { unlink($tempfile); }
    mkdir($tempfile);
    if (is_dir($tempfile)) { return $tempfile; }
}

$tempdir = tempdir();
$tempdir = "/tmp/zap";
$student_code = $tempdir . "/student.c";
file_put_contents($student_code, $code);

$command = "/opt/homebrew/bin/emcc -sFORCE_FILESYSTEM -sEXIT_RUNTIME=1 -Wno-implicit-int student.c";
$stdin = null;
$cwd = $tempdir; 
$env = null;
$timeout = 10.0;

$compile = cc4e_pipe($command, $stdin, $cwd, $env, $timeout);

$hexfolder = bin2hex($tempdir);
$js = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.js';
$wasm = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.wasm';

$retval = array('code' => $code, 'tmpdir' => $tempdir, 'command' => $command, 'js' => $js, 'wasm' => $wasm, 'compile' => $compile);
?>
<head>
</head>
</body>
<h1>EmScriptEn Executor</h1>

<?php 

if ( strlen($retval['js'] ?? '' ) > 0 ) {
?>

    <div class="spinner" id='spinner'></div>
    <div class="emscripten" id="status">Ready...</div>

    <div class="emscripten">
      <progress value="0" max="100" id="progress" hidden=1></progress>
    </div>



<form method="post" action="index.php">
<textarea name="code" id="code" style="width:95%;" rows="5">
<?php echo(htmlentities($code)); ?>
</textarea>

<textarea name="input" id="input" style="width:95%;" rows="5">
<?php echo(htmlentities($input)); ?>
</textarea>
<br/>
<textarea name="output" id="output" style="width:95%;" rows="5"></textarea>
<br/>
<textarea name="stderr" id="stderr" style="width:95%;" rows="5"></textarea>
<input type="submit">
</form>

<script type='text/javascript'>

var inputPosition = 0;

      var statusElement = document.getElementById('status');
      var progressElement = document.getElementById('progress');
      var spinnerElement = document.getElementById('spinner');
      var Module = {
        print: (function() {
          var element = document.getElementById('output');
          if (element) element.value = ''; // clear browser cache
          return function(text) {
            if (arguments.length > 1) text = Array.prototype.slice.call(arguments).join(' ');
            // These replacements are necessary if you render to raw HTML
            //text = text.replace(/&/g, "&amp;");
            //text = text.replace(/</g, "&lt;");
            //text = text.replace(/>/g, "&gt;");
            //text = text.replace('\n', '<br>', 'g');
            console.log(text);
            if (element) {
              element.value += text + "\n";
              element.scrollTop = element.scrollHeight; // focus on bottom
            }
          };
        })(),
        setStatus: (text) => {
          if (!Module.setStatus.last) Module.setStatus.last = { time: Date.now(), text: '' };
          if (text === Module.setStatus.last.text) return;
          var m = text.match(/([^(]+)\((\d+(\.\d+)?)\/(\d+)\)/);
          var now = Date.now();
          if (m && now - Module.setStatus.last.time < 30) return; // if this is a progress update, skip it if too soon
          Module.setStatus.last.time = now;
          Module.setStatus.last.text = text;
          if (m) {
            text = m[1];
            progressElement.value = parseInt(m[2])*100;
            progressElement.max = parseInt(m[4])*100;
            progressElement.hidden = false;
            spinnerElement.hidden = false;
          } else {
            progressElement.value = null;
            progressElement.max = null;
            progressElement.hidden = true;
            if (!text) spinnerElement.style.display = 'none';
          }
          statusElement.innerHTML = text;
        },
        preRun: function() {
          // Return ASCII code of character, or null if no input
          function stdin() {
              var inputText = document.getElementById('input').value;
              if ( inputPosition >= inputText.length ) return null;
              return inputText.charCodeAt(inputPosition++);
          }

          // Do something with the asciiCode
          function stdout(asciiCode) {
            var element = document.getElementById('output');
            element.value += String.fromCharCode(asciiCode);
          }

          // Do something with the asciiCode
          function stderr(asciiCode) {
            var element = document.getElementById('stderr');
            element.value += String.fromCharCode(asciiCode);
          }

          FS.init(stdin, stdout, stderr);
        },
        totalDependencies: 0,
        monitorRunDependencies: (left) => {
          this.totalDependencies = Math.max(this.totalDependencies, left);
          Module.setStatus(left ? 'Preparing... (' + (this.totalDependencies-left) + '/' + this.totalDependencies + ')' : 'All downloads complete.');
        }
      };
      Module.setStatus('Ready...');
      window.onerror = (event) => {
        // TODO: do not warn on ok events like simulating an infinite loop or exitStatus
        Module.setStatus('Exception thrown, see JavaScript console');
        spinnerElement.style.display = 'none';
        Module.setStatus = (text) => {
          if (text) console.error('[post-exception status] ' + text);
        };
      };

</script>

<script src="<?= $retval['js'] ?>"></script>

<?php } ?>



<!--
<pre>
<?php 
var_dump($retval);
var_dump($_POST);
?>
</pre>
-->


</body>
</html>
