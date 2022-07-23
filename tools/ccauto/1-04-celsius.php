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
Modify the temperature conversion program to print a heading above the table.
Check the sample output for the required format of the heading.
EOF
;
}

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

