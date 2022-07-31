<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>K&R Exercise 3-6.</b> 
    <p>
    Write a program which copies its input to its output, except that it prints only one instance from 
    each group of adjacent identical lines. (This is a simple version of the UNIX utility uniq.)
    </p>
    <p>
    You can use the <b>strcpy(dest, src)</b> from the <b>string.h</b> to copy one string (character array)
    to another.  You can also use <b>strcmp(s1,s2)</b> to compare two strings (character arrays).  <b>strcmp()</b>
    returns zero if the strings are equal.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { return false; }

function ccauto_input($LAUNCH) { 
    return <<< EOF
One line
Two Line
Red Line
Blue line
Blue line
Blue line
Yada
Yada
Yada
Last line
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
One line
Two Line
Red Line
Blue line
Yada
Last line
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
    char line[1000];
    char keep[1000];

    while(gets(line) != NULL ) {
        strcpy(keep, line);
        printf("%s\\n",keep);
    }
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('Yada', "Yada, yada - if we let you  hard code your output you won't actually learn anything. And we can't have that."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
    char line[1000];
    char keep[1000];
    int first = 1;

    while(gets(line) != NULL ) {
        if ( first == 1 ) {
            strcpy(keep, line);
            printf("%s\\n", line);
            first = 0;
            continue;
        }
        if ( strcmp(keep, line) == 0 ) continue;
        strcpy(keep, line);
        printf("%s\\n",keep);
    }
}
EOF
;
}

