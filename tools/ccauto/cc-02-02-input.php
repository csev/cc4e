<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-2:</b> Write a C program equivalent to
this Python program:
<pre>
print('Enter US Floor')
usf = int(input())
euf = usf - 1
print('EU Floor', euf)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
2
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    int usf, euf;
    printf("Enter US Floor\\n");
    scanf("%d", &usf);
    euf = usf - 1;
    printf("EU Floor %d\\n", euf);
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Enter US Floor
EU Floor 1
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
function ccauto_prohibit($LAUNCH) { return false; }
function ccauto_require($LAUNCH) { 
    return array(
        array('scanf', 'You should use scanf to read the input.'),
        array('-', 'It is difficult to subtract without using subtraction.'),
    );
}

