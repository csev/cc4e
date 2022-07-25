<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

global $ASSIGNMENT;

$ASSIGNMENT = true;

// Called first
function ccauto_instructions($LAUNCH) {
    return '<b>Exercise 1-1.</b> Please write a program to print "Hello world"';
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return false; } 

function ccauto_sample($LAUNCH) { return <<< EOF
#include <stdio.h>
main() {
  printq("Hello world\\n");
}
EOF
;
}

function ccauto_output($LAUNCH) { return "Hello world"; }

function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { return false; }

