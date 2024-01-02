<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

// https://blog.dubbelboer.com/2012/08/24/execute-with-timeout.html
function cc4e_pipe($command, $stdin, $cwd, $env, $timeout)
{

    $retval = new \stdClass();
    $retval->stdout = false;
    $retval->stderr = false;
    $retval->status = false;
    $retval->failure = false;

    $begin = microtime(true);

    $descriptorspec = array(
       0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
       2 => array("pipe", "w") // stderr is a file to write to
    );

    // Pipes is set by proc_open
    $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

    if (is_resource($process)) {
        // $pipes now looks like this:
        // 0 => writeable handle connected to child stdin
        // 1 => readable handle connected to child stdout
        // 2 => readable handle connected to child stderr

        // Set the stdout stream to non-blocking.
        stream_set_blocking($pipes[1], 0);

        // Set the stderr stream to non-blocking.
        stream_set_blocking($pipes[2], 0);

        // Turn the timeout into microseconds.
        $timeout = (int) ($timeout * 1000000);

        // Output buffer.
        $stdout = '';
        $stderr = '';

        if ( is_string($stdin) ) {
            fwrite($pipes[0], $stdin);
        }
        fclose($pipes[0]);

        // While we have time to wait.
        $retval->failure = 'timeout';
        while ($timeout > 0) {
            $start = microtime(true);

            // Wait until we have output or the timer expired.
            $read  = array($pipes[1]);
            $other = array();
            stream_select($read, $other, $other, 0, (int) $timeout);

            // Get the status of the process.
            // Do this before we read from the stream,
            // this way we can't lose the last bit of output if the process dies between these functions.
            $status = proc_get_status($process);
            $ppid = $status['pid'];
            $retval->ppid = $status['pid'];

            // Read the contents from the stdout.
            // This function will always return immediately as the stream is non-blocking.
            $stdout .= stream_get_contents($pipes[1]);
            if ( strlen($stdout) > 20000 ) {
                $retval->failure = 'Output length exceeded';
                $retval->ppid = $ppid;
                if ( stripos(PHP_OS, "darwin") !== 0 ) {
                    $pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
                    $retval->pids = $pids;
                    foreach($pids as $pid) {
                        if(is_numeric($pid)) {
                            error_log("Killing $pid\n");
                            posix_kill($pid, 9); //9 is the SIGKILL signal
                        }
                    }
                }
                $stdout = "";
                break;
            }

            $stderr .= stream_get_contents($pipes[2]);
            if ( strlen($stderr) > 20000 ) {
                $retval->failure = 'stderr length exceeded '.$ppid;
                $retval->ppid = $ppid;
                if ( stripos(PHP_OS, "darwin") !== 0 ) {
                    $pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
                    $retval->pids = $pids;
                    foreach($pids as $pid) {
                        if(is_numeric($pid)) {
                            error_log("Killing $pid\n");
                            posix_kill($pid, 9); //9 is the SIGKILL signal
                        }
                    }
                }
                $stderr = "";
                break;
            }

            if (!$status['running']) {
                // Break from this loop if the process exited before the timeout.
                $retval->failure = false;
                break;
            }

            // Subtract the number of microseconds that we waited.
            $timeout -= (microtime(true) - $start) * 1000000;
        }

        // var_dump($status);
        $retval->status = $status['exitcode'];

        // Close all streams.
        fclose($pipes[1]);
        fclose($pipes[2]);

        // Kill the process in case the timeout expired and it's still running.
        // If the process already exited this won't do anything.
        proc_terminate($process, 9);

        // proc_close in order to avoid a deadlock
        $retval->stdout = $stdout;
        $retval->stderr = $stderr;

    } else {
        $retval->failure = 'resource';
    }
    $retval->ellapsed = (microtime(true) - $begin);

    return $retval;
}

function cc4e_emcc($user_id, $code, $input, $main=null, $note=null)
{
    global $CFG;
    $retval = new \stdClass();
    $now = str_replace('@', 'T', gmdate("Y-m-d@H-i-s"));
    $retval->now = $now;
    $retval->code = $code;
    $retval->input = $input;
    $retval->reject = false;
    $retval->hasmain = false;

    // Some sanity checks
    if ( strlen($code) > 20000 ) {
        $retval->reject = "Code too large";
        return $retval;
    }

    if ( strlen($input) > 20000 ) {
        $retval->reject = "Input too large";
        return $retval;
    }

    for($i=0; $i<strlen($input); $i++) {
        $ord = ord($input[$i]);
        if ( $ord < 1 || $ord > 126 ) {
            $retval->reject = "Input has non-ascii character: ".$ord." @".$i;
            return $retval;
        }
    }

    for($i=0; $i<strlen($code); $i++) {
        $ord = ord($code[$i]);
        if ( $ord < 1 || $ord > 126 ) {
            $retval->reject = "Code has non-ascii character: ".$ord." @".$i;
            return $retval;
        }
    }

    $env = array(
       'some_option' => 'aeiou',
       'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
    );

    // Add any driver code that is required
    if ( is_string($main) && strlen($main) > 0 ) {
        $before = $main;
        $after = "";
        $pos = strpos($main, 'int main(');
        if ( $pos > 0 ) {
            $before = substr($main, 0, $pos-1);
            $after = substr($main, $pos);
        }
        $marker = '#include "student.c"';
        $pos = strpos($main, $marker);
        if ( $pos > 0 ) {
            $before = substr($main, 0, $pos-1);
            $after = substr($main, $pos+strlen($marker));
        }
        $code = $before . "\n" . $code . "\n" . $after;
    }

    $emcc_folder = U::get($CFG->extensions, 'emcc_folder', "/tmp");

    $now = str_replace('@', 'T', gmdate("Y-m-d@H-i-s"));
    $retval->now = $now;
    $tempdir = $emcc_folder . '/' . $now . '-' . substr(md5(uniqid()),0,5);
    mkdir($tempdir);

    $student_code = $tempdir . "/student.c";
    file_put_contents($student_code, $code);

    if ( is_string($note) && strlen($note) > 1 ) {
        $retval->note = $note;
    }

    $emcc_options = '-ansi -Wno-fortify-source -Wno-implicit-function-declaration -Wno-return-type -Wno-deprecated-non-prototype -Wno-pointer-to-int-cast -Wno-int-conversion -Wno-deprecated-declarations';
    $emcc_options = U::get($CFG->extensions, 'emcc_options', $emcc_options);
    $emcc_path = U::get($CFG->extensions, 'emcc_path', "/opt/homebrew/bin/emcc");

    $command = "$emcc_path -sFORCE_FILESYSTEM -sEXIT_RUNTIME=1 $emcc_options student.c";
    $stdin = null;
    $cwd = $tempdir;
    $env = null;
    $timeout = 10.0;

    $retval->docker = cc4e_pipe($command, $stdin, $cwd, $env, $timeout);

    $retval->tempdir = $tempdir;
    $retval->user_id = $user_id;

    $hexfolder = bin2hex($tempdir);
    if ( strlen($retval->docker->stderr) < 1 ) {
        $retval->js = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.js';
        $retval->wasm = $CFG->apphome . '/emcompile/load.php/' . $hexfolder . '/a.out.wasm';
        $retval->hasmain = true;
    }

    $json = json_encode($retval, JSON_PRETTY_PRINT);
    file_put_contents($tempdir . '/result.json', $json);

    // echo("<pre>\n");print_r($retval);die();
    return $retval;
}

function cc4e_emcc_get_output($retval, $displayname, $email, $user_id)
{
    if ( ! is_object($retval) ) return;
    if ( ! is_object($retval->docker) ) return;
    if ( strlen(U::get($_POST, "emcc_output", '')) < 1 ) return;

    $tempdir = $retval->tempdir ?? '';
    if ( strlen($tempdir) < 1 || ! is_dir($tempdir) ) {
        $retval->reject = "Unable to find compiler working directory";
    } else if ( ($retval->user_id ?? -1) != $user_id ) {
        $retval->reject = "Unable to re-connect user in compiler working directory";
    } else {
        $output = substr(U::get($_POST, 'emcc_output', ''), 0, 20000);
        $_SESSION['output'] = $output;
        $retval->docker->stdout = $output;
        $retval->output = $output;
        $retval->displayname = $displayname;
        $retval->email = $email;

        $json = json_encode($retval, JSON_PRETTY_PRINT);
        file_put_contents($tempdir . '/result.json', $json);
    }
}

function cc4e_emcc_execute($post_url, $retval, $pause) {

    $js = $retval->js;
    if ( ! is_object($retval) || ! is_string($retval->js) || strlen($retval->js) < 1 ) die('need compile results in session');
    $code = $retval->code ?? '';
    $input = $retval->input ?? '';
    if ( strlen($code) < 1 ) die('Need code');
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
then send the output back to the main page.  If this screen stops or waits long enough for you to see it,
something is likely happening incorrectly - or you have an infinite loop :)
</p>

    <div class="spinner" id='spinner'></div>
    <div class="emscripten" id="status">Ready...</div>

    <div class="emscripten">
      <progress value="0" max="100" id="progress" hidden=1></progress>
    </div>



    <form method="post" action="<?= $post_url ?>" id="form">
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


<?php
}

function cc4e_rate_limit($retval)
{
    $bucket = U::get($_SESSION,"leaky_bucket", null);
    $now = time();
    if ( ! is_array($bucket) ) $bucket = array();
    $deltas = array();
    $newbucket = array();
    $count = 0;

    $BUCKET_MAX = 4;
    $BUCKET_RATE = 30; // One compile per 30 seconds
    $BUCKET_SIZE = 4;  // Burst rate
    $BUCKET_TIME = $BUCKET_RATE * $BUCKET_MAX;
    foreach($bucket as $when) {
        $delta = $now - $when;
        // Drop compiles beyond period
        if ( $delta > $BUCKET_TIME ) continue;
        $newbucket[] = $when;
        $count = $count + 1;
        $deltas[] = $delta;
    }

    if ( $count >= $BUCKET_SIZE ) {
        if ( ! is_object($retval) ) {
            $retval = new \stdClass();
            $retval->docker = new \stdClass();
        }
        $retval->docker->stdout = "";
        $retval->docker->stderr = "Rate Exceeded...";
        $_SESSION['retval'] = $retval;
        return true;
    } else {
        $newbucket[] = $now;
        $_SESSION["leaky_bucket"] = $newbucket;
        return false;
    }
}

// Weirdness in shell copying input
// Note, we can't use <<- because it is ash :(
function escape_heredoc($doc) {
   $srch = array(
        "\\\\",
        "$"
    );
    $repl = array(
        "\\\\\\\\",
        "\\$",
    );
     $retval = str_replace($srch, $repl, $doc);
     return $retval;
}

