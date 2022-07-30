<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-13:</b> Write a C function called <b>py_rstrip()</b>
that removes spaces from the end of a string.
EOF
;
}

// Blanks at the end are intentional
function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return <<< EOF
void py_rstrip(inp)
    char inp[];
{
    int i, j;
    for(i=0, j=0; i<strlen(inp)-1; i++) {
        if ( inp[i] == '\\n' ||
             inp[i] == '\\t' || inp[i] == ' ' ) {
            /* Whitespace skip  */
        } else {
            j = i; /* last non-blank */
        }
    }
    if ( j+1 < strlen(inp) ) inp[j+1] = '\\0';
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
-   Hello   World-
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
int main() {
    char s1[] = "   Hello   World    ";
    void py_rstrip();
    py_rstrip(s1);
    printf("-%s-\\n", s1);
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { return false; }

