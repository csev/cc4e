<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-7:</b> Write a C program to produce the same output as
this Python program, using the <b>gets</b> function instead of <b>scanf</b>.
<pre>
maxval = None
minval = None
while True:
    line = input()
    line = line.strip()
    if line == "done" : break
    ival = int(line)
    if ( maxval is None or ival > maxval) :
        maxval = ival
    if ( minval is None or ival < minval) :
        minval = ival

print('Maximum', maxval)
print('Minimum', minval)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
5
2
9
done
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
int main() {
    int first = 1;
    int val, maxval, minval;
    char line[1000];

    while(gets(line) != NULL ) {
        if ( strcmp(line,"done") == 0 ) break;
        val = atoi(line);
        if ( first ) {
            maxval = val;
            minval = val;
            first = 0;
        } else {
            if ( val > maxval ) maxval = val;
            if ( val < minval ) minval = val;
        }
    }

    printf("Maximum %d\\n", maxval);
    printf("Minimum %d\\n", minval);
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Maximum 9
Minimum 2
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
function ccauto_require($LAUNCH) { return false; }

