<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise cc-2-3:</b> Write a C program equivalent to
this Python program:
<pre>
print('Enter name')
name = input()
print('Hello', name)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
Sarah
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
int main() {
    char name[100];
    printf("Enter name\\n");
    scanf("%100s", name);
    printf("Hello %s\\n", name);
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Enter name
Hello Sarah
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

