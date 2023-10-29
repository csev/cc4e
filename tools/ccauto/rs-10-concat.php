<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) { return <<< EOF
<b>Exercise RS-10:</b> Write a C program to prompt for two strings and
concatenate them as shown in in the Python code below.
Use the functions <b>strcpy</b> and <b>strcat</b> from the 
<b>string.h</b> library in your code.
Pre-allocate your character arrays large enought to handle up to 100 characters on input for each string (i.e. do not use malloc as we have
not yet covered that yet).
<pre>
print('Enter two strings');
first = input()
second = input()
print(first + " & " + second)
</pre>
EOF
;
}

function ccauto_input($LAUNCH) { return <<< EOF
Kernighan
Ritchie
EOF
;
}

function ccauto_solution($LAUNCH) { return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
    char first[100], second[100], concat[303];
    printf("Enter two strings\\n");
    scanf("%100s", first);
    scanf("%100s", second);
    strcpy(concat, first);
    strcat(concat, " & ");
    strcat(concat, second);
    printf("%s\\n", concat);
}
EOF
;
}

function ccauto_output($LAUNCH) { return <<< EOF
Enter two strings
Kernighan & Ritchie
EOF
;
}

function ccauto_sample($LAUNCH) {  return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
    printf("Hello world\\n");
}
EOF
;
} 

function ccauto_main($LAUNCH) { return false; }
function ccauto_prohibit($LAUNCH) { 
    return array(
        array('Kernighan', "Uh - you should prompt for the string values to concatenate."),
    );
}
function ccauto_require($LAUNCH) { return false; }

