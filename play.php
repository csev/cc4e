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

if ( U::get($_SESSION,'id', null) === null ) {
    $_SESSION['error'] = 'Must be logged in to test code';
    header("Location: index.php");
    return;
}

require_once "sandbox/sandbox.php";
require_once "play_util.php";

$stdout = False;
$stderr = False;

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
        $retval = cc4e_compile($code, $input);
        $_SESSION['retval'] = $retval;
    }
}

$lines = $code ? count(explode("\n", $code)) : 15;

echo("<html>\n");
cc4e_play_header($lines);
?>
</head>
<body>
<p>
This the <a href="index.php">www.cc4e.com</a> code playground for writing C programs.
<p>
<form method="post">
<p>
<input type="submit" value="Run Code">
<script>
if ( window.opener ) {
    document.write('<button onclick="window.close();">Close</button>');
} else {
    document.write('<input type="submit" onclick="window.location=\'index.php\'; return false;" value="Back to CC4E">');
}
</script>
</p>
<?php
$errors = cc4e_play_errors($retval);
cc4e_play_inputs($lines, $code);
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
cc4e_play_footer();
?>
</body>
