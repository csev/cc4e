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
<b>Exercise 1-3.</b>
Modify the temperature conversion program to print a heading above the table.
Check the sample output for the required format of the heading.
EOF
;
}

function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) { return <<< EOF
#include <stdio.h>
main() /* Fahrenheit-Celsius table */
{
    int fahr;
    for (fahr = 0; fahr <= 300; fahr = fahr + 40)
        printf("%4d %6.1f\\n", fahr, (5.0/9.0)*(fahr-32));
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    global $RANDOM_CODE;
    $header = array (
        "Fahr   Celsius\n",
        "FAHR   CELSIUS\n",
        "F      C\n",
    );
    $output = $header[$RANDOM_CODE % 3];
    $output .= ($RANDOM_CODE % 2) ? "---------------\n" : "===============\n";
    $output .= <<< EOF
   0  -17.8
  40    4.4
  80   26.7
 120   48.9
 160   71.1
 200   93.3
 240  115.6
 280  137.8
EOF
;
    
    return $output;
}

function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { return false; }

