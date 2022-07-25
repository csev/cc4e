<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Exercise 1-6.</b> Count blanks and new lines.  We skip tabs because it is a little tricky.
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { return romeo(); }

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
main() /* count new lines in input */
{
    int c, nl;
    nl = 0;
    while ((c = getchar()) != EOF)
        if (c == '\\n')
            ++nl;
    printf("%d\\n", nl);
}
EOF
;
}

function ccauto_output($LAUNCH) {
    global $RANDOM_CODE;
    $output = <<< EOF
29 4
EOF
;

    return $output;
}

function ccauto_prohibit($LAUNCH) {
    return array(
        array('29', 'Please do not hard-code results - you must compute the answers'),
        array('4', 'Please do not hard-code results - you must compute the answers'),
    );
}

function ccauto_require($LAUNCH) {
    return array(
        array('getchar', 'You should use getchar() to read the input characters'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
main() /* count new lines in input */
{
    int c, nl, ns;
    nl = ns = 0;
    while ((c = getchar()) != EOF) {
        if (c == '\\n') ++nl;
        if (c == ' ') ++ns;
    }
    printf("%d %d\\n", ns, nl);
}
EOF
;
}

