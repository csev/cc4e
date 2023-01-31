<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    global $CFG;
    return <<< EOF
<b>LBS290 Exercise 4.</b> 
    Fix the syntax errors in this program.<br/>
    <b>Fun Fact:</b>Dr. Chuck used this exact assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/" target="_blank"> in LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { 
    return false;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
/* Assignment 4 */

/* Program which requires fixing some syntax errors */

#include "stdio.h"

main () {

  char c;
  int 1value;
  int i;
  flat x;

  printf("Hello there and welcome to the program\\n);

  i = 10;

  x = 2.50;

  x = x + 1.L;

  1value = 15;

/* This is a comment

  printf("This statement should print out, why doesn't it?\\n");

/* And another comment */

  printf("This statement does print out, yay!\\n");

}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
Hello there and welcome to the program
This statement should print out, why doesn't it?
This statement does print out, yay!
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('1value', 'Hmmm - there *are* rules for naming C variables.'),
        array('flat', 'Hmmm - "flat" is not a C type..'),
    );
}

function ccauto_require($LAUNCH) { 
    return array(
        array('x = 2.50;', "Please don't delete code - jut fix the errors."),
        array('i = 10;', "Please don't delete code - jut fix the errors."),
        array('char c;', "Please don't delete code - jut fix the errors."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { return false; }

