<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Celsius Farenheight Function</b> 
    <p>
    You should write a function (no #include statements are needed) called faren(cel)
    that takes as input a double Celsuis temparature and converts it and returns
    the equivalent Farenheight value.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
int main() {
  double faren();
  printf("faren(42) is %f\\n", faren(42.0));
  printf("faren(0) is %f\\n", faren(0.0));
  printf("faren(32) is %f\\n", faren(32.0));
  printf("faren(100) is %f\\n", faren(100.0));
  printf("faren(212) is %f\\n", faren(212.0));
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Lower M is m
Lower x is x
Lower @ is @
Lower $CHAR_2_10 is $LOWER_2_10
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
double faren(celsius)
double celsius;
{
  // Do something :)
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return array(
        array('include', 'You should not have any include statements in your code.'),
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array("faren", "You need to name your function faren()."),
        array('return', 'You must use a return statement'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
double faren(cel) 
double cel;
{
  return (cel * 9.0 / 5.0) + 32.0;
}
EOF
;
}

