<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $RATE_3_1, $HOURS_3_1, $PAY_3_1, $PAY_3_1_STR;
    $RATE_3_1 = (($RANDOM_CODE_HOUR % 1000) + 1500) / 100.0;
    $HOURS_3_1 = (($RANDOM_CODE_HOUR % 2000) + 3500) / 100.0;
    $PAY_3_1 = ($RATE_3_1 * $HOURS_3_1);
    if ( $HOURS_3_1 > 40 ) $PAY_3_1 = $PAY_3_1 + ($RATE_3_1 * 1.5 * ($HOURS_3_1 - 40.0));
    $PAY_3_1_STR = sprintf("%7.2f", $PAY_3_1);

    return <<< EOF
<b>PY4E Exercise 3.1.</b> 
    <p>
    Write a program to prompt the user for hours and rate per hour using scanf to compute gross pay. 
    Pay the hourly rate for the hours up to 40 and 1.5 times the hourly rate for all hours worked.
    You should use scanf to read your two float values.
    Do not worry about error checking the user input - assume the user types numbers properly. 
    </p>
    <p>
    The provided values may change from time to time but as long as your program does the correct
    computation, you will get the correct result.
    </p>
EOF
;
}

function ccauto_input($LAUNCH) { 
    GLOBAL $RATE_3_1, $HOURS_3_1, $PAY_3_1, $PAY_3_1_STR;
    return sprintf("%7.2f %7.2f\n", $RATE_3_1, $HOURS_3_1);
}

function ccauto_output($LAUNCH) { 
    GLOBAL $RATE_3_1, $HOURS_3_1, $PAY_3_1, $PAY_3_1_STR;
    return <<< EOF
Pay: $PAY_3_1_STR
EOF
;
}


// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    float rate;
    scanf("%f", &rate);
    printf("Rate: %7.2f\\n", rate);
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    GLOBAL $RANDOM_3_1, $RATE_3_1, $HOURS_3_1, $PAY_3_1, $PAY_3_1_STR;
    return array(
        array($PAY_3_1_STR, 'You cannot hard-code the output.'),
        array('42', 'The value 42, while important, does not belong in the implementation of this function.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('float', 'The function is dealing with float type variables'),
        array('40', 'How to you figure when the hours are above 40, when you don\'t use 40 anywhere in your code?'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    float pay, rate, hours;
    scanf("%f", &rate);
    scanf("%f", &hours);
    pay = rate * hours;
    if ( hours > 40.0 ) pay = pay + (rate*(hours-40.0)*1.5);
    printf("Pay: %7.2f\\n", pay);
}
EOF
;
}

