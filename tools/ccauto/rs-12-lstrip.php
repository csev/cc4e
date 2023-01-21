<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise RS-12:</b> Write a C function called <b>py_lstrip()</b>
that removes whitespace (blanks, tabs, and newlines) from the beginning of a string.
This function modifies its parameter and should never be called with a constant value.
EOF
;
}

// Blanks at the end are intentional
function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return <<< EOF
void py_lstrip(inp)
    char inp[];
{
    int i, j;
    int found = 0;
    for(i=0, j=0; i<strlen(inp)-1; i++) {
        if ( ! found && isspace(inp[i]) ) continue;
        if ( i == j ) return;
        found = 1;
        inp[j++] = inp[i];
    }
    inp[++j] = '\\0';
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
-Hello   World    -
EOF
;
}

function ccauto_sample($LAUNCH) {  return <<< EOF
void py_rstrip(inp)
    char inp[];
{
    printf("Some code goes here...\\n");
}
EOF
;
}

function ccauto_main($LAUNCH) { return <<< EOF
#include <stdio.h>
#include <string.h>
#include <ctype.h>
int main() {
    char s1[] = "   Hello   World    ";
    void py_lstrip();
    py_lstrip(s1);
    printf("-%s-\\n", s1);
}
EOF
;
}

function ccauto_require($LAUNCH) {
    return array(
        array("py_lstrip", "You need to name your function py_lstrip()."),
    );
}

function ccauto_prohibit($LAUNCH) {
    return array(
        array("main", "Don't include the main() code - only include the py_lstrip() function - the main code is provided automatically by the autograder."),
        array("Hello", "Yes this is a difficult assignment - but the solution is presented and discussed in the lecture."),
        array("H", "Sigh, a correct implementation of this function rarely requires the use of an uppercase 'H'."),
    );
}
