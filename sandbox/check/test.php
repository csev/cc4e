<?php

require_once("../../tsugi/config.php");
require_once("../sandbox.php");

use Tsugi\Util\U;

if ( ! U::isCli() ) die('CLI Only');

$files = glob("*.c");
foreach ($files as $file) {
    echo("\n\n--------------- $file ----------------\n");
    $code = file_get_contents($file);
    $input = "42 43 44\n45 46 47\n";
    echo($code);
    $retval = cc4e_compile($code, $input);

    $fail = false;

    $compile = $retval->assembly->status == 0;
    $failure = isset($retval->docker->failure) && is_string($retval->docker->failure) ? $retval->docker->failure : false;

    if ( ! $compile ) {
       $fail = "Compiler error"; 
    } else {

        $allowed = !(strpos($file,'allow') > 0);
        $minimum = !(strpos($file,'minimum') > 0);
        $timeout = (strpos($file,'timeout') > 0);
        $stdout = (strpos($file,'stdout') > 0);

        if ( $retval->allowed === $allowed ) {
            // Cool
        } else {
            $fail = "Allowed mismatch";
        }

        if ( $retval->minimum === $minimum ) {
            // Cool
        } else {
            $fail = "Minmum mismatch";
        }

        if ( is_string($failure) ) {
            if ( $failure == 'timeout' && $timeout ) {
                // Cool
            } else if ( strpos($failure, "exceeded")> 0  && $stdout ) {
                // Cool
            } else {
                $fail = "Docker failure: ". $failure;
            }
        } else if ( $retval->allowed &&  $retval->minimum ) {
            $output =  $retval->docker->stdout;
            if ( strlen($output) < 1 ) {
                $fail = "Did not produce any output";
            }
        }

    }

    if ( is_string($fail) ) {
        echo("\n-------------------------------\n");
        echo(json_encode($retval, JSON_PRETTY_PRINT));
        $debug = true;
        if ( $debug && isset($retval->assembly->stdout) && is_string($retval->assembly->stdout) ) {
            echo("\n");
            echo($retval->assembly->stdout);
        }
        echo("FAIL: $fail\n");
    break;
    }    
}

