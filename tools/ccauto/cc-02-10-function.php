<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-10:</b> Write a C function to implement this Python code:
<pre>
def mymult(a,b):
    c = a * b
    return c
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return <<< EOF
int mymult(a, b)
    int a,b;
{
    int c = a * b;
    return c;
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Answer: 42
EOF
;
}

function ccauto_sample($LAUNCH) {  return <<< EOF
int mymult() {
    return 42;
}
EOF
;
} 

function ccauto_main($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    int mymult();
    int retval;

    retval = mymult(6,7);
    printf("Answer: %d\\n",retval);
}
EOF;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('42', 'While 42 is a very important number, it is not part of the correct solution to this problem.'),
    );
}

function ccauto_require($LAUNCH) { return false; }

