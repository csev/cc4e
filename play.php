<?php
if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: index.php");
    return;
}

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

$BUCKET_RATE = 30; // One compile per 30 seconds
$BUCKET_MAX = 4;

$LOGGED_IN = U::get($_SESSION,'id', null) !== null;
$displayname = U::get($_SESSION,'displayname', null);
$email = U::get($_SESSION,'email', null);

require_once "sandbox/sandbox.php";
require_once "play_util.php";

// If this is a new compile request - post - session - redirect
if ( isset($_POST['new_compile']) ) {
    unset($_SESSION['retval']);
    $_SESSION['code'] = U::get($_POST, 'code', false);
    $_SESSION['input'] = U::get($_POST, 'input', '');
    header("Location: play.php");
    return;
}

$retval = U::get($_SESSION, 'retval');

if ( is_object($retval) && is_object($retval->docker) && strlen(U::get($_POST, "emcc_output", '')) > 0 ) {
    cc4e_emcc_get_output($retval, $displayname, $email, $_SESSION['id']);
    $_SESSION['retval'] = $retval;
}

$sample = U::get($_REQUEST, 'sample');
// if ( ! preg_match('/^[a-zA-Z_0-9]+.md$/', $sample) ) $sample = false;
if ( is_string($sample) ) {
    unset($_SESSION['code']);
    unset($_SESSION['input']);
    unset($_SESSION['retval']);
    $code = file_get_contents('book/code/'.$sample);
    $retval = null;
    $input = null;  /* TODO - Get this as well */
    $output = null;
} else {
    $code = U::get($_SESSION, 'code');
    $input = U::get($_SESSION, 'input');
    $retval = U::get($_SESSION, 'retval');
    if ( $retval == NULL && is_string($code) && strlen($code) > 0 ) {
        if ( cc4e_rate_limit($retval) ) {
            $retval = $_SESSION['retval']; // reload
        } else {
            $succinct = preg_replace('/\s+/', ' ', $code);
            $note = "play.php ".$displayname.' '.$email.': '.substr($succinct,0, 250);
            error_log($note);
            $main = null;
            $retval = cc4e_emcc($_SESSION['id'], $code, $input, $main, $note);
            $_SESSION['retval'] = $retval;
            if ( isset($retval->js) ) {
                header("Location: em_run.php");
                return;
            }
        }
    }
}

$lines = $code ? count(explode("\n", $code)) : 15;

echo("<!DOCTYPE html>\n<html>\n<head>\n");
cc4e_play_header($lines);
?>
<style>
.CodeMirror-scroll { max-height: <?= intval(($lines/13)*20) ?>em; }
</style>
</head>
<body>
<p>
<?php if ( $LOGGED_IN ) { ?>
This is the <a href="index.php">www.cc4e.com</a> code playground for writing C programs.
You can also check
<a href="https://status.cc4e.com" target="_blank">recent status</a> of this
compiler page.
<?php
    if ( U::get($_REQUEST, "sample", null) != null ) {
        echo(' Note that not all of the sample programs in the book compile and run using a modern compiler.');
    }
    echo("<!-- leaky bucket \n");
    $bucket = U::get($_SESSION,"leaky_bucket", null);
    if ( is_array($bucket) ) foreach($bucket as $when) {
        echo(time() - $when);
        echo("\n");
    }
    echo("-->\n");
} else {
?>
You must be logged in to run your program on this site.  There are a number of
free online <a href="compilers.php">C Compilers</a> that you can use.
<?php } ?>
<p>
<form method="post">
<p>
<?php
if ( $LOGGED_IN ) {
    echo('<input type="submit" name="new_compile" value="Run Code" id="runcode">');
}
?>
<script>
if ( window.opener ) {
    document.write('<button onclick="window.close();">Close</button>');
} else {
    document.write('<input type="submit" onclick="window.location=\'index.php\'; return false;" value="Back to CC4E">');
}
</script>
<?php
echo("</p>\n");
$errors = cc4e_play_errors($retval);
cc4e_play_inputs($lines, $code);
if ( $LOGGED_IN ) {
?>
<p>Input to your program:</p>
<p>
<textarea id="myinput" name="input" style="width:100%; border: 1px black solid;">
<?php
if ( is_string($input) ) {
    echo(htmlentities($input));
} ?>
</textarea>
</p>
</form>
<?php if ( is_object($retval) && isset($retval->docker) && is_object($retval->docker) && is_string($retval->docker->stdout) && strlen($retval->docker->stdout) > 0 ) {
  $rows = substr_count( $retval->docker->stdout, "\n" );
  if ( $rows < 5 ) $rows = 5;
  if ( $rows > 30 ) $rows = 30;
?>
<p>
Program Output:
</p>
<p>
<textarea id="myoutput" name="output" style="width:100%; border: 1px black solid;" rows="<?= $rows ?>">
<?php echo(htmlentities($retval->docker->stdout)); ?>
</textarea>
</p>
<?php } ?>
<p>
This page uses a server-based compiler called
<a href="https://emscripten.org/" target="_blank">Emscripten</a> that compiles
your code to JavaScript and then executes your code in the browser.  You can watch
your browser developer console to monitor how your code is being executed.
If this fails with an unexpected error, please add a note in the
<a href="<?= $CFG->apphome ?>/discussions">Discussions</a>
area.
</p>
<?php
cc4e_play_debug($retval);
} else {
    echo("\n</form>\n");
}
?>
<script src="https://static.tsugi.org/js/jquery-1.11.3.js"></script>
<?php
cc4e_play_footer();
?>
</body>
