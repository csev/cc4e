<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Using 'static' data</b> 
    <p>
    You should write a function called bump() that uses an static variable
    so that the first time it is called, it returns int 0, the next time it returns
    1 and so on.  Also write a function called start() which takes an int as its parameter
    and restarts the sequence from the specivied number.
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
  void start();
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
  printf("bump() returns %d\\n", bump());
  start(42);
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
bump() returns 42
bump() returns 43
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
        array("extern", "You should not use the 'extern' keyword."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array("static", "You need to use the 'static' keyword."),
        array("bump", "You need to have a bump() function."),
        array("start", "You need to have a start() function."),
        array('return', 'You must use a return statement'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
static int BUMP_VAL = 0;

int bump() 
{
  return BUMP_VAL++;
}

void start(int start) 
{
  BUMP_VAL = start;
}
EOF
;
}

