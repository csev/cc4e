<?php

use \Tsugi\Util\u;

require_once "tsugi/config.php";

if ( U::get($_REQUEST, "secret") != "42" ) die('');

$retval = file_get_contents($CFG->apphome . "/ping.php");
$obj = json_decode($retval);
$output = $obj->docker->stdout;
echo($output);
