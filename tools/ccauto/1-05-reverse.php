<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

global $ASSIGNMENT;

$ASSIGNMENT = true;

function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Exercise 1-5.</b> Modify the temperature conversion program to print the table in reverse order, that is, from 300 degrees to 0.
EOF
;
}

function ccauto_input($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
main() /* Fahrenheit-Celsius table */
{
    int fahr;
    for (fahr = 300; fahr >= 0; fahr = fahr - 20)
        printf("%4d %6.1f\\n", fahr, (5.0/9.0)*(fahr-32));
}
EOF
;

}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) { 
    $sample = <<< EOF
#include <stdio.h>
main() /* Fahrenheit-Celsius table */
{
    int fahr;
    for (fahr = 0; fahr <= 300; fahr = fahr + 20)
        printf("%4d %6.1f\\n", fahr, (5.0/9.0)*(fahr-32));
}
EOF
;

    return $sample;

}

function ccauto_output($LAUNCH) { 
    global $RANDOM_CODE;
    $output = <<< EOF
 300  148.9
 280  137.8
 260  126.7
 240  115.6
 220  104.4
 200   93.3
 180   82.2
 160   71.1
 140   60.0
 120   48.9
 100   37.8
  80   26.7
  60   15.6
  40    4.4
  20   -6.7
   0  -17.8
EOF
;
    
    return $output;
}

function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { return false; }

