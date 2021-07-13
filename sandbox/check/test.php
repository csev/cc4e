<?php

require_once("../../tsugi/config.php");
require_once("../sandbox.php");

use Tsugi\Util\U;

if ( ! U::isCli() ) die('CLI Only');

$files = glob("*.c");
foreach ($files as $file) {
    echo("\n\n--------------- $file ----------------\n");
    $code = file_get_contents($file);
    $input = false;
    echo($code);
    $retval = cc4e_compile($code, $input);
    echo("\n-------------------------------\n");
    echo(json_encode($retval, JSON_PRETTY_PRINT));

    $compile = $retval->assembly->status == 0;
    if ( ! $compile ) {
        die("Compiler error");
    }

    $allowed = !(strpos($file,'allow') > 0);
    $minimum = !(strpos($file,'minimum') > 0);

    if ( $retval->allowed === $allowed ) {
        // Cool
    } else {
        echo("*** Allowed mismatch\n");
        die();
    }

    if ( $retval->minimum === $minimum ) {
        // Cool
    } else {
        echo("*** Minimum mismatch\n");
        die();
    }


    $debug = true;
    if ( $debug && isset($retval->assembly->stdout) && is_string($retval->assembly->stdout) ) {
        echo("\n");
        echo($retval->assembly->stdout);
    }

}

