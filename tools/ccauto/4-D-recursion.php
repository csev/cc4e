<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Writing a Recursive Function</b> 
    <p>
    You should write a recursive function called <b>sumseries()</b> that takes as its
    input a single integer and returns the sum of all the numbers from 1..the provided number.
    This is very similar to the function described in lecture except for some error checking.
    First, if the provided number is less than one, return zero as the sum.  Also,
    in order to avoid stack overflow, if the provided number is above 100 return -1.
    You cannot use a <b>do</b>, <b>for</b>, or integer division to compute the sum since that
    would not be recursive :).
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
int main() {
  printf("sumseries(0) returns %d\\n", sumseries(0));
  printf("sumseries(1) returns %d\\n", sumseries(1));
  printf("sumseries(5) returns %d\\n", sumseries(5));
  printf("sumseries(42) returns %d\\n", sumseries(42));
  printf("sumseries(-42) returns %d\\n", sumseries(-42));
  printf("sumseries(100) returns %d\\n", sumseries(100));
  printf("sumseries(101) returns %d\\n", sumseries(101));
  printf("sumseries(1000) returns %d\\n", sumseries(1000));
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
sumseries(0) returns 0
sumseries(1) returns 1
sumseries(5) returns 15
sumseries(42) returns 903
sumseries(-42) returns 0
sumseries(100) returns 5050
sumseries(101) returns -1
sumseries(1000) returns -1
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
int sumseries(ival)
    int ival;
{
    return 42;
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('include', 'You should not have any include statements in your code.'),
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("extern", "You should not use the 'extern' keyword."),
        array("for", "You should not have a 'for' loop."),
        array("while", "You should not have a 'while' loop."),
        array("/", "While integer division is a great way to solve this problem, we must use recursion."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('return', 'You must use a return statement'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
int sumseries(ival) 
    int ival;
{
   if ( ival > 100 ) return -1;
   if ( ival < 1 ) return 0;
   if ( ival == 1 ) return 1;
   return ival + sumseries(ival-1);
}
EOF
;
}

