<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

global $ASSIGNMENT;

$ASSIGNMENT = true;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Exercise 1-7.</b> Write a program to copy its input to its output, replacing each string of one or more blanks by a single blank.
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { 
    return <<< EOF
But soft  what light     through yonder window breaks
It is    the east and  Juliet is the sun
Arise fair sun   and kill the envious moon
Who  is  already  sick  and  pale  with  grief
EOF
    ;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
main() {
    int c;
    while ((c = getchar()) != EOF) {
        putchar(c);
    } 
}
EOF
;
}

function ccauto_output($LAUNCH) { return romeo(); }

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('soft', 'You cannot hard-code the output.'),
    );
}

function ccauto_require($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
main() {
    int c, space = 0;
    while ((c = getchar()) != EOF) {
        if ( c != ' ' || space == 0 ) putchar(c);
        space = c == ' ';
    } 
}
EOF
;
}

