<?php
if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
    header("Location: ../index.php");
    return;
}

use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

if ( ! isset($CFG) ) {
    if (!defined('COOKIE_SESSION')) define('COOKIE_SESSION', true);
    require_once "../tsugi/config.php";
    $LAUNCH = LTIX::session_start();
}

if ( U::get($_SESSION,'id', null) === null ) {
    die('Must be logged in');
}

require_once "sandbox.php";

/*
$ip = $_SERVER['REMOTE_ADDR'] ?? false;
if ( ! is_string($ip) ) die('No REMOTE_ADDR');

$public = filter_var(
    $ip, 
    FILTER_VALIDATE_IP, 
    FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
);

if ( is_string($public) ) {
	die('bad address');
}
 */

$displayname = U::get($_SESSION,'displayname', null);

$code = $_POST['code'] ?? false;
$input = $_POST['input'] ?? false;
if ( ! is_string($code) ) die('No code');

$main = null;

$retval = cc4e_compile($code, $input, $main, $displayname);

header("Content-type: application/json; charset=utf-8");
echo(json_encode($retval, JSON_PRETTY_PRINT));

$debug = false;
if ( $debug && isset($retval->assembly->stdout) && is_string($retval->assembly->stdout) ) {
    echo("\n");
    echo($retval->assembly->stdout);
}
