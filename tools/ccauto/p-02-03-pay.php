<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $RATE_2_3, $HOURS_2_3, $PAY_2_3, $PAY_2_3_STR;
    $RATE_2_3 = (($RANDOM_CODE_HOUR % 1000) + 1500) / 100.0;
    $HOURS_2_3 = (($RANDOM_CODE_HOUR % 2000) + 3500) / 100.0;
    $PAY_2_3 = ($RATE_2_3 * $HOURS_2_3);
    $PAY_2_3_STR = sprintf("%7.2f", $PAY_2_3);

    return <<< EOF
<b>PY4E Exercise 2.3.</b> 
    <p>
    Write a program to prompt the user for rate per hour and hours working using scanf and then 
    compute gross pay without overtime.
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
    GLOBAL $RATE_2_3, $HOURS_2_3, $PAY_2_3, $PAY_2_3_STR;
    return sprintf("%7.2f %7.2f\n", $RATE_2_3, $HOURS_2_3);
}

function ccauto_output($LAUNCH) { 
    GLOBAL $RATE_2_3, $HOURS_2_3, $PAY_2_3, $PAY_2_3_STR;
    return <<< EOF
Pay: $PAY_2_3_STR
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
    GLOBAL $RANDOM_2_3, $RATE_2_3, $HOURS_2_3, $PAY_2_3, $PAY_2_3_STR;
    return array(
        array($PAY_2_3_STR, 'You cannot hard-code the output.'),
        array('42', 'The value 42, while important, does not belong in the implementation of this function.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('float', 'The function is dealing with float type variables'),
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
    printf("Pay: %7.2f\\n", pay);
}
EOF
;
}

