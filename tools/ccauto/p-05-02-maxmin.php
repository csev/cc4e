<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $NUMBERS_5_2;

    $NUMBERS_5_2 = array();
    $val = $RANDOM_CODE_HOUR;
    for($i=0; $i<20; $i++ ) {
        $val = ($val * 22 / 7) % 10000000;
        $NUMBERS_5_2[] = $val % 100;
    }

    return <<< EOF
<b>PY4E Exercise 5.2.</b> 
    <p>
    Write a program that repeatedly prompts a user for integer numbers until end-of-file on the input.  Once EOF is 
    encountered, print out the largest and smallest of the numbers. 
    </p>
    <p>
    Each time you run the program, the numbers may change, but if you write the program correctly, it will always work.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $NUMBERS_5_2;
    return implode(' ', $NUMBERS_5_2);
}

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $NUMBERS_5_2;
    return "Maximum is ".max($NUMBERS_5_2)."\nMinimum is ".min($NUMBERS_5_2);
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    int numb;
    while ( scanf("%d", &numb) > 0 ) {
        printf("Read: %d\\n",numb);
    }
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('%f', 'This program handles integers, not float values.'),
        array('42', 'The value 42, while important, does not belong in the implementation of this program.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('int', 'The function is dealing with int type variables'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    int numb, first, minval, maxval;
    first = 1;
    while ( scanf("%d", &numb) > 0 ) {
        if ( first || numb < minval ) minval = numb;
        if ( first || numb > maxval ) maxval = numb;
        first = 0;
    }
    printf("Maximum is %d\\n", maxval);
    printf("Minimum is %d\\n", minval);
}
EOF
;
}

