<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise RS-7:</b> Write a C program to determine the minmum and maximum
of a sequence of integer numbers on input, terminged by the string "done".
The patterns for input and output should match the following Python application.
Make sure that the input lines can be at least 1000 characters.
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
function ccauto_prohibit($LAUNCH) { 
    return array(
        array('9', "This is a pretty challenging assignment, but lets not take short cuts. The solution *is* described in the lecture for this material.  Sometimes lectures have useful information - who knew?"),
    );
}

function ccauto_require($LAUNCH) { return false; }

