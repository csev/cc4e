<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    $x = $RANDOM_CODE_HOUR % 40;
    if ( $x < 20 ) {
        $CHAR_2_10 = chr(ord('b') + $x);
    } else {
        $CHAR_2_10 = chr(ord('B') + ($x - 20));
    }
    $LOWER_2_10 = strtolower($CHAR_2_10);
    return <<< EOF
<b>K&R Exercise 2-10.</b> 
    <p>
    You should write a function (no #include statements are needed) called lower(c)
    that converts its input parameter to lower case.  If the letter is not
    an upper case ASCII letter - just return the parameter unchanged.
    You should not use ctype.h and your code can assume the ASCII character set.
    You should use the queston mark operator and not an if-then-else construct.
    </p>
    <p>
    Each time you run the program, the values you need to convert 
    may be different each time you run the code.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
#include <stdio.h>
int main() {
  int lower();
  printf("Lower M is %c\\n", lower('M'));
  printf("Lower x is %c\\n", lower('x'));
  printf("Lower @ is %c\\n", lower('@'));
  printf("Lower $CHAR_2_10 is %c\\n", lower('$CHAR_2_10'));
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
int lower(c) /* convert c to lower case; ASCII only */
int c;
{
  if (c >= 'A' && c <= 'Z')
    return(c + 'a' - 'A');
  else
    return(c);
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return array(
        array('ctype', 'You should not use ctype.h.'),
        array('include', 'You should not have any include statements in your code.'),
        array('else', 'You are to use a conditional expression, not an if-then-else.'),
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
int lower(c) /* convert c to lower case; ASCII only */
int c;
{
  return ( (c >= 'A' && c <= 'Z') ? (c + 'a' - 'A') : c );
}
EOF
;
}

