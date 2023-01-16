<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $INT_2_1;
    $INT_2_1 = ($RANDOM_CODE_HOUR % 5) + 15;
    return <<< EOF
<b>Exercise RS-1:</b> Write a C program to produce the same output as
this Python program using the %d and %s features of the printf() function:
<pre>
print('Hello world')
print('Answer', $INT_2_1)
print('Name', 'Sarah')
</pre>
EOF
;
}

function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { return false; }

function ccauto_sample($LAUNCH) {  return <<< EOF
#include <stdio.h>
int main() {
    printf("Hello world\\n");
}
EOF
;
} 

function ccauto_solution($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $INT_2_1;
    return <<< EOF
#include <stdio.h>
int main() {
    printf("Hello world\\n");
    printf("Answer %d\\n", $INT_2_1);
    printf("Name %s\\n", "Sarah");
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $INT_2_1;
    return <<< EOF
Hello world
Answer $INT_2_1
Name Sarah
EOF
;
}

function ccauto_prohibit($LAUNCH) {
    return array(
    );
}

function ccauto_require($LAUNCH) {
    return array(
        array("%s", 'You must use %s to format your output.'),
        array("%d", 'You must use %d to format your output.'),
    );
}

