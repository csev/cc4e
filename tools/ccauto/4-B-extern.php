<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Using 'extern' data</b> 
    <p>
    You should write a function called bump() that uses an extern variable
    so that the first time it is called, it returns int 0, the next time it returns
    1 and so on.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
int main() {
  int bump();
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
bump() returns 0
bump() returns 1
bump() returns 2
bump() returns 3
bump() returns 4
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
int bump()
{
  // Do something :)
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('include', 'You should not have any include statements in your code.'),
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("static", "You should not use the 'static' keyword."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array("extern", "You need to use the 'extern' keyword."),
        array("bump", "You need to name your function bump()."),
        array('return', 'You must use a return statement'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
int BUMP_VAL = 0;

int bump() 
{
  extern int BUMP_VAL;
  return BUMP_VAL++;
}
EOF
;
}

