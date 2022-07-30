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
while True:
    try:
        line = input()
    except:  # If we get EOF
        break
    line = line.strip()
    guess = int(line)
    if guess == 42:
        print('Nice work!')
        break
    elif guess < 42 :
        print('Too low - guess again')
    else :
        print('Too high - guess again')
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
5
50
42
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    int guess;
    while(scanf("%d",&guess) != EOF ) {
        if ( guess == 42 ) {
            printf("Nice work!\\n");
            break;
        }
        else if ( guess < 42 )
            printf("Too low - guess again\\n");
        else
            printf("Too high - guess again\\n");
    }
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Too low - guess again
Too high - guess again
Nice work!
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

