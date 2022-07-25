<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Exercise 1-10.</b> Write a program which prints the words in its input, one per line.  A word
is any string separated by a space or newline,
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) {
    return <<< EOF
But soft what light
through yonder window
breaks
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

function ccauto_output($LAUNCH) { 
    return <<< EOF
But
soft
what
light
through
yonder
window
breaks
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('soft', 'You must not hard code the output'),
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
        if ( c == ' ' || c == '\\n' ) {
            if ( ! space ) putchar('\\n');
            space = 1;
        } else {
            putchar(c);
            space = 0;
        }
    }
}
EOF
;
}

