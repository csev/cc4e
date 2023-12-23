<?php

use \Tsugi\Util\U;

require_once "tsugi/config.php";

if ( U::get($_REQUEST, "secret") != "42" ) die('');

$retval = file_get_contents($CFG->apphome . "/ping.php");
$obj = json_decode($retval);
if ( is_object($obj)) {
   if ( isset($obj->js) ) {
       echo("Hello world\n");
   } else {
       echo($obj->docker->stderr);
   }
}
