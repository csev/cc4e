<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>K&R Exercise 1-4.</b> Write a program to print the corresponding Celsius to Fahrenheit table.
Check the sample output for the required format of the heading.
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) { return <<< EOF
#include <stdio.h>
main() /* Fix this to be Celsius-Fahrenheit table */
{
    int cel;
    for (cel = 0; cel <= 100; cel = cel + 40)
        printf("%4d %6.1f\\n", cel, (cel+32.0));
}
EOF
;
}

function ccauto_solution($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    $output = <<< EOF
   0   32.0
  20   68.0
  40  104.0
  60  140.0
  80  176.0
 100  212.0
EOF
;
    
    return $output;
}

function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { return false; }

