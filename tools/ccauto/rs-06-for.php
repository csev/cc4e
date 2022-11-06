<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise RS-6:</b> Write a C program to produce the same output as
this Python program using a 'for' loop.
<pre>
for i in range(5) :
    print(i)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return false; }

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    int i;
    for(i=0; i<5; i++) {
        printf("%d\\n",i);
    }
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
0
1
2
3
4
EOF
;
}

function ccauto_sample($LAUNCH) {  return <<< EOF
#include <stdio.h>
int main() {
    printf("Hello world\\n");
}
EOF
;
} 

function ccauto_main($LAUNCH) { return false; }
function ccauto_prohibit($LAUNCH) {
    return array(
        array('2', "Hmmm, I can't see a good reason to have the number '2' in the solution to this program."),
    );
}
function ccauto_require($LAUNCH) { 
    return array(
        array('for', "The instructions do mention a for loop above :)."),
    );
}

