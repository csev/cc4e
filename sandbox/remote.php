<?php
use \Tsugi\Core\LTIX;
use \Tsugi\Util\U;

require_once "../tsugi/config.php";
require_once "sandbox.php";

$cfg_password = $CFG->getExtension('remote_incoming_password', '');
if ( strlen($cfg_password) < 1 ) die('Remote not configured');

// echo("<pre>\n");var_dump($_POST);die();

$password = $_POST['password'] ?? false;
$code = $_POST['code'] ?? false;
$input = $_POST['input'] ?? false;
$main = $_POST['main'] ?? null;
$note = $_POST['note'] ?? null;
if ( ! is_string($code) ) die('No code');
if ( $cfg_password != $password ) die('Bad password');

error_log("Remote incoming: ".$note);

$retval = cc4e_compile_internal($code, $input, $main);

header("Content-type: application/json; charset=utf-8");
echo(json_encode($retval, JSON_PRETTY_PRINT));

