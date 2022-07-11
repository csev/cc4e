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

require_once "sandbox/sandbox.php";
require_once "play_util.php";

if ( isset($_POST['code']) ) {
    unset($_SESSION['retval']);
    $_SESSION['code'] = U::get($_POST, 'code', false);
    $_SESSION['input'] = U::get($_POST, 'input', false);
    header("Location: play.php");
    return;
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
} else {
    $code = U::get($_SESSION, 'code');
    $input = U::get($_SESSION, 'input');
    $retval = U::get($_SESSION, 'retval');
    if ( $retval == NULL && is_string($code) && strlen($code) > 0 ) {
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

        if ( $count >= $BUCKET_SIZE ) {
            $retval = new \stdClass();
            $retval->assembly = new \stdClass();
            $retval->assembly->stderr = "Rate Exceeded...";
            $_SESSION['retval'] = $retval;
        } else {
            $newbucket[] = $now;
            $retval = cc4e_compile($code, $input);
            $_SESSION['retval'] = $retval;
            $_SESSION["leaky_bucket"] = $newbucket;
        }
    }
}

$lines = $code ? count(explode("\n", $code)) : 15;

echo("<html>\n<head>\n");
cc4e_play_header($lines);
?>
</head>
<body>
<p>
This is the <a href="index.php">www.cc4e.com</a> code playground for writing C programs
It is a very limited environment - you can find more full-featured
C compilers <a href="compilers.php">online</a>.
<?php
if ( U::get($_REQUEST, "sample", null) != null ) {
	echo(' Note that not all of the sample programs in the book compile and run using a modern compiler.');
}
?>
<?php
if ( ! $LOGGED_IN ) {
    echo('You must be logged in to run your program.');
}

echo("<!-- leaky bucket \n");
$bucket = U::get($_SESSION,"leaky_bucket", null);
if ( is_array($bucket) ) foreach($bucket as $when) {
    echo(time() - $when);
    echo("\n");
}
echo("-->\n");


?>
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
<span id="runstatus"><img src="<?= $OUTPUT->getSpinnerUrl() ?>"/></span>
</p>
<?php
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
<?php cc4e_play_output($retval); ?>
</form>
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
