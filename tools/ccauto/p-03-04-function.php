<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $RATE_3_4, $HOURS_3_4, $PAY_3_4, $PAY_3_4_STR;
    $RATE_3_4 = (($RANDOM_CODE_HOUR % 1000) + 1500) / 100.0;
    $HOURS_3_4 = (($RANDOM_CODE_HOUR % 2000) + 3500) / 100.0;
    $PAY_3_4 = ($RATE_3_4 * $HOURS_3_4);
    if ( $HOURS_3_4 > 40 ) $PAY_3_4 = $PAY_3_4 + ($RATE_3_4 * 1.5 * ($HOURS_3_4 - 40.0));
    $PAY_3_4_STR = sprintf("%7.2f", $PAY_3_4);

    return <<< EOF
<b>PY4E Exercise 4.6.</b> 
    <p>
    We will provide a program that will give you a randomly chosen number of hours and rate per hour.
    You should write a function (no #include statements are needed) called computepay(hours, rate)
    that computes the correct pay and returns it as a float.
    Pay should be the normal rate for hours up to 40 and time-and-a-half for the hourly 
    rate for all hours worked above 40 hours.  
    </p>
    <p>
    Each time you run the program, the values
    like hours ($HOURS_3_4) and rate ($RATE_3_4) and the 
    resulting pay ($PAY_3_4_STR) may be different each time you run the code.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    GLOBAL $RATE_3_4, $HOURS_3_4, $PAY_3_4, $PAY_3_4_STR;
    return <<< EOF
#include <stdio.h>
int main() {
  float rate = $RATE_3_4;
  float hours = $HOURS_3_4;

  float retval, computepay();
  retval = computepay(rate, hours);
  printf("Pay: %7.2f\\n", retval);
  retval = computepay(rate, 35.0);
  printf("Pay: %7.2f\\n", retval);
  retval = computepay(rate, 45.0);
  printf("Pay: %7.2f\\n", retval);
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RATE_3_4, $HOURS_3_4, $PAY_3_4, $PAY_3_4_STR;
    $pay_35 = sprintf("%7.2f", $RATE_3_4*35.0);
    $pay_45 = sprintf("%7.2f", $RATE_3_4*45.0);
    return <<< EOF
Pay: $PAY_3_4_STR
Pay: $pay_35
Pay: $pay_45
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
float computepay(hours, rate) 
    float hours, rate;
{
    return 42.0;
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    GLOBAL $RANDOM_3_4, $RATE_3_4, $HOURS_3_4, $PAY_3_4, $PAY_3_4_STR;
    return array(
        array($PAY_3_4_STR, 'You cannot hard-code the output.'),
        array('include', 'You should not have any include statements in your code.'),
        array('42', 'The value 42, while important, does not belong in the implementation of this function.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('return', 'You must use a return statement'),
        array('float', 'The function is dealing with float type variables'),
        array('40', 'How to you figure when the hours are above 40, when you don\'t use 40 anywhere in your code?'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
float computepay(hours, rate) 
    float hours, rate;
{
    float pay = rate*hours;
    if ( hours > 40.0 ) pay = pay + (hours-40.0) * rate * 1.5;
    return pay;
}
EOF
;
}

