<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $VALUE_2_10, $HEX_2_10;
    $VALUE_2_10 = (($RANDOM_CODE_HOUR % 30000) + 30000) * 16 + ($RANDOM_CODE_HOUR % 5) + 10;
    $HEX_2_10 = sprintf("%x", $VALUE_2_10);


    return <<< EOF
<b>K&R Exercise 2-2.</b> 
    <p>
    You should write a function (no #include statements are needed) called htoi(str)
    that converts  hexadecimal constant (base-16 0-9 and a-f) to an integer.
    There will not be a '0x' prefix (like in C) - just assume the input is a hex number.
    You should not use ctype.h and your code can assume the ASCII character set.
    </p>
    <p>
    Each time you run the program, the values you need to convert <b>$HEX_2_10</b> (base-16)
    to <b>$VALUE_2_10</b> (base-10)
    may be different each time you run the code.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $VALUE_2_10, $HEX_2_10;
    return <<< EOF
#include <stdio.h>
int main() {
  int htoi();
  printf("htoi('$HEX_2_10') = %d\\n", htoi("$HEX_2_10"));
  printf("htoi('f') = %d\\n", htoi("f"));
  printf("htoi('F0') = %d\\n", htoi("F0"));
  printf("htoi('12fab') = %d\\n", htoi("12fab"));
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $VALUE_2_10, $HEX_2_10;
    return <<< EOF
htoi('$HEX_2_10') = $VALUE_2_10
htoi('f') = 15
htoi('F0') = 240
htoi('12fab') = 77739
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
int atoi(s) /* convert s to integer */
char s[];
{
    int i, n;

    n = 0;
    for (i = 0; s[i] >= '0' && s[i] <= '9'; ++i)
        n = 10 * n + s[i] - '0';
    return(n);
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('include', 'You should not have any include statements in your code.'),
        array('42', 'The value 42, while important, does not belong in the implementation of this function.'),
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
int htoi(s) /* convert hex in s to integer */
char s[];
{
    int i, n;

    n = 0;
    for (i = 0; s[i]; ++i) {
        if (s[i] >= '0' && s[i] <= '9')
            n = 16 * n + s[i] - '0';
        else if ( (s[i] >= 'a' && s[i] <= 'f') )
            n = 16 * n + s[i] - 'a' + 10;
        else if ( (s[i] >= 'A' && s[i] <= 'F') )
            n = 16 * n + s[i] - 'A' + 10;
        else
            return n;
    }
    return(n);
}
EOF
;
}

