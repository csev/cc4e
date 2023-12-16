<?php
if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: index.php");
    return;
}

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

$BUCKET_RATE = 30; // One compile per 30 seconds
$BUCKET_MAX = 4;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

$LOGGED_IN = U::get($_SESSION,'id', null) !== null;
$displayname = U::get($_SESSION,'displayname', null);
$email = U::get($_SESSION,'email', null);

require_once "sandbox/sandbox.php";
require_once "play_util.php";

if ( isset($_POST['code']) ) {
    unset($_SESSION['retval']);
    $_SESSION['code'] = U::get($_POST, 'code', false);
    $_SESSION['input'] = U::get($_POST, 'input', false);
    $_SESSION['output'] = U::get($_POST, 'output', false);
    header("Location: play.php");
    return;
}

if (isset($_POST['code']) && strlen($code) < 1)  {
    header("");
    return;
}

$sample = U::get($_REQUEST, 'sample');
// if ( ! preg_match('/^[a-zA-Z_0-9]+.md$/', $sample) ) $sample = false;
if ( is_string($sample) ) {
    unset($_SESSION['code']);
    unset($_SESSION['input']);
    unset($_SESSION['output']);
    unset($_SESSION['retval']);
    $code = file_get_contents('book/code/'.$sample);
    $retval = null;
    $input = null;  /* TODO - Get this as well */
    $output = null;
} else {
    $code = U::get($_SESSION, 'code');
    $input = U::get($_SESSION, 'input');
    $retval = U::get($_SESSION, 'retval');
    $output = U::get($_SESSION, 'output', '');
    if ( strlen($output) > 0 && strlen($CFG->getExtension('emscripten_secret', '')) > 0 ) {
        if ( $retval == null ) $retval = new \stdClass();
        if ( ! isset($retval->docker) ) $retval->docker = new \stdClass();
        $retval->docker->stdout = $output;
    } else if ( $retval == NULL && is_string($code) && strlen($code) > 0 ) {
        $bucket = U::get($_SESSION,"leaky_bucket", null);
        $now = time();
        if ( ! is_array($bucket) ) $bucket = array();
        $deltas = array();
        $newbucket = array();
        $count = 0;

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

        if ( false && $count >= $BUCKET_SIZE ) {
            $retval = new \stdClass();
            $retval->assembly = new \stdClass();
            $retval->assembly->stderr = "Rate Exceeded...";
            $_SESSION['retval'] = $retval;
        } else {
            $newbucket[] = $now;
            $succinct = preg_replace('/\s+/', ' ', $code);
            $note = "Compile by ".$displayname.' '.$email.': '.substr($succinct,0, 250);
            error_log($note);
            $main = null;
            $retval = cc4e_compile($code, $input, $main, $note);
            $_SESSION['retval'] = $retval;
            $_SESSION["leaky_bucket"] = $newbucket;
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
    echo('<input type="submit" value="Run Code" id="runcode" disabled>');
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
if ( $LOGGED_IN ) {
    echo('<span id="runstatus"><img src="'.$OUTPUT->getSpinnerUrl().'"/></span>');
}
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
<?php
if ( is_string($output) && strlen($output) > 0 ) {
?>
<textarea id="myoutput" name="output" style="width:100%; border: 1px black solid;">
<?php echo(htmlentities($output));
} else {
?>
<textarea id="myoutput" name="output" style="display:none; width:100%; border: 1px black solid;">
<?php } ?>
</textarea>
</p>
<?php cc4e_play_output($retval); ?>
</form>
<p>
This compiler uses a pretty complex docker setup to run your code - you
might get  "docker error" or a "timeout" if there is a problem with the
compiler environment.  Usually you can just re-try a
compile and it will work.  There is a
<a href="https://status.cc4e.com/" target="_blank">status page</a>
that runs a test every minute or two on this site and monitors the reliability
of its C compiler.
</p>
<p>
<p>This code execution environment has extensive security filters that
start by blocking every function you might call and then
having a precise "allowed functions" list.  As we gain experience, the list will be expanded.
 If you think that it is blocking function calls that it should allow, please add a note in the
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
