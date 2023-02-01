<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    global $CFG;
    return <<< EOF
<b>LBS290 Exercise 8.</b> 
This program will prompt for 5 floating point numbers.  The program will
print out the total of the five numbers and also print out the average.
<br/>
    <b>Fun Fact:</b>Dr. Chuck used this exact assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn08.txt" target="_blank"> in LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { 
   return <<< EOF
10.0
5.0
15.0
20.0
10.0
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include "stdio.h"

main () {
  printf("The total is: %.1f\\n", 60.0);
  printf("The average is: %.1f\\n", 12.0);
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
The total is: 60.0
The average is: 12.0
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('60', 'You should compute the answers.'),
        array('12', 'You should compute the answers.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array(
        array('scanf', "You should use scanf to read the data."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
int main() {
    float tot=0, n=0, val;
    while ( scanf("%f", &val) == 1 ) {
        tot += val;
        n++;
    }
    printf("The total is: %.1f\\n", tot);
    printf("The average is: %.1f\\n", tot/n);
}

EOF
;
}

