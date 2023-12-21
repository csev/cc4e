<!DOCTYPE html>
<?php

use \Tsugi\Util\U;
use \Tsugi\Core\LTIX;

if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
require_once "tsugi/config.php";
$LAUNCH = LTIX::session_start();

$code = U::get($_SESSION, 'code');
$input = U::get($_SESSION, 'input');
$retval = U::get($_SESSION, 'retval');
// TODO: Add isInstrutor()
$pause = U::get($_COOKIE, 'emcc_pause', 'false') == 'true';

if ( strlen($code) < 1 ) die('Need code');
if ( ! is_object($retval) || ! is_string($retval->js) || strlen($retval->js) < 1 ) die('need compile results in session');

$js = $retval->js;
?>
<head>
<!-- https://stackoverflow.com/a/20741964/1994792 -->
<style>
.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(256,256,256,.9);
}
.loading-wheel {
    width: 20px;
    height: 20px;
    margin-top: -40px;
    margin-left: -40px;

    position: absolute;
    top: 50%;
    left: 50%;

    border-width: 30px;
    border-radius: 50%;
    -webkit-animation: spin 1s linear infinite;
}
.style-2 .loading-wheel {
    border-style: double;
    border-color: #ccc transparent;
}
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0);
    }
    100% {
        -webkit-transform: rotate(-360deg);
    }
}
</style>
</head>
<body>
<div class="loading style-2" id="loading"><div class="loading-wheel"></div></div>

<p>Executing...</p>
<div id="debug" style="display:none;">
<p>You should not see this screen.  It should briefly blink, run your compiled code in the browser, and
then send the output back to the main page.  If this screen stops or waits long enought for you to see it, 
something is likely happening incorrectly - or you have an infinite loop :)
</p>

    <div class="spinner" id='spinner'></div>
    <div class="emscripten" id="status">Ready...</div>

    <div class="emscripten">
      <progress value="0" max="100" id="progress" hidden=1></progress>
    </div>



<form method="post" action="play.php" id="form">
<textarea name="code_dont_post" id="code" style="width:95%;" rows="5">
<?php echo(htmlentities($code)); ?>
</textarea>

<textarea name="input_dont_post" id="input" style="width:95%;" rows="5">
<?php echo(htmlentities($input)); ?>
</textarea>
<br/>
<textarea name="emcc_output" id="output" style="width:95%;" rows="5"></textarea>
<br/>
<textarea name="stderr" id="stderr" style="width:95%;" rows="5"></textarea>
<input type="submit">
</form>
</div>

<script type='text/javascript'>

var inputPosition = 0;
var lastReturnCharacter = 0;

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
              if ( inputPosition >= inputText.length ) {
                  // Make sure that the last character of input is a newline
                  if (lastReturnCharacter != 10 ) {
                      lastReturnCharacter = 10;
                      return lastReturnCharacter;
                  }
                  return null;
              }
              lastReturnCharacter = inputText.charCodeAt(inputPosition++);
              return lastReturnCharacter;
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
        onExit: (status) => {
            console.log('Execution complete status='+status);
<?php if ( ! $pause ) { ?>
            document.getElementById("form").submit();
<?php } ?>
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
        console.log('Exception thrown, see JavaScript console');
        spinnerElement.style.display = 'none';
        Module.setStatus = (text) => {
          if (text) console.error('[post-exception status] ' + text);
        };
      };

</script>

<script src="<?= $js ?>"></script>

<script>
console.log('Loading your application...');
setTimeout( () => {
    console.log('Exception taking too long, showing debug detail');
    document.getElementById("loading").style.display = "none";
    document.getElementById("debug").style.display = "block";
}, "2000");
</script>

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
