<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Celsius to  Farenheight Conversion</b> 
    <p>
    You should write a function called faren(cel)
    that takes as input a double Celsuis temperature and converts it and returns
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
  printf("faren(42) is %.1f\\n", faren(42.0));
  printf("faren(0) is %.1f\\n", faren(0.0));
  printf("faren(-10) is %.1f\\n", faren(-10.0));
  printf("faren(32) is %.1f\\n", faren(32.0));
  printf("faren(100) is %.1f\\n", faren(100.0));
  printf("faren(212) is %.1f\\n", faren(212.0));
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
faren(42) is 107.6
faren(0) is 32.0
faren(-10) is 14.0
faren(32) is 89.6
faren(100) is 212.0
faren(212) is 413.6
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

