<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    GLOBAL $RANDOM_CODE_HOUR, $SCORE_3_4, $GRADE_3_4;
    $SCORE_3_4 = (($RANDOM_CODE_HOUR % 50) + 50) / 100.0;
    $GRADE_3_4 = "Error";

    if ( $SCORE_3_4 >= 0.9 ) $GRADE_3_4 = "A";
    else if ( $SCORE_3_4 >= 0.8 ) $GRADE_3_4 = "B";
    else if ( $SCORE_3_4 >= 0.7 ) $GRADE_3_4 = "C";
    else if ( $SCORE_3_4 >= 0.6 ) $GRADE_3_4 = "D";
    else if ( $SCORE_3_4 >= 0.0 ) $GRADE_3_4 = "F";

    return <<< EOF
<b>PY4E Exercise 3.4.</b> 
    <p>
    Write a program to prompt for a float score between 0.0 and 1.0 using scanf. If the score is out of range, print an error. 
    If the score is between 0.0 and 1.0, print a single character grade using the following table:
<pre>
Score Grade
>= 0.9 A
>= 0.8 B
>= 0.7 C
>= 0.6 D
< 0.6 F
</pre>
    </p>
    <p>
    The provided values may change from time to time but as long as your program does the correct
    computation, you will get the correct result.
    </p>
EOF
;
}

function ccauto_input($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $SCORE_3_4, $GRADE_3_4;
    return sprintf("%.3f\n", $SCORE_3_4);
}

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $SCORE_3_4, $GRADE_3_4;
    return sprintf("%s\n", $GRADE_3_4);
}


// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { return false; }

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    float score;
    scanf("%f", &score);
    printf("Score: %7.2f\\n", score);
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('42', 'The value 42, while important, does not belong in the implementation of this function.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('float', 'The function is dealing with float type variables'),
        array('scanf', 'Please use scanf to read the score?'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
    float score;
    scanf("%f", &score);
    if ( score >= 0.9 ) printf("A\\n");
    else if ( score >= 0.8 ) printf("B\\n");
    else if ( score >= 0.7 ) printf("C\\n");
    else if ( score >= 0.6 ) printf("D\\n");
    else if ( score >= 0.0 ) printf("F\\n");
    else printf("Error\\n");
}
EOF
;
}

