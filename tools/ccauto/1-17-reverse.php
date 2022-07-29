<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>K&R Exercise 1-17.</b> 
    <p>
    You should write a function called <b>reverse(s)</b> that reverses the characters
    in a string.  Reverse the string in place.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
  char t[1000];
  char *copy();
  void reverse();
  copy("Hello world", t);
  printf("%s\\n", t);
  reverse(t);
  printf("%s\\n", t);
  reverse(copy("Even", t));
  printf("%s\\n", t);
  reverse(copy("Odd", t));
  printf("%s\\n", t);
  reverse(copy("civic", t));
  printf("%s\\n", t);
}

/* copy s1 to s2; assume s2 big enough */
char *copy(s1, s2)
char s1[], s2[];
{
    int i;
    for(i=0;(s2[i] = s1[i]);i++);
    return s2;
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    return <<< EOF
Hello world
dlrow olleH
nveE
ddO
civic
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void reverse(t)
char t[];
{
    printf("Write a for loop here\\n");
    return;
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array("strrev", "You cannot use standard linbraries for this - nice try."),
        array("include", "You cannot use any include files for this."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
void reverse(t)
char t[];
{
    int i, len;
    char tmp;
    len = strlen(t);
    for(i=0;i<=(len/2);i++) {
        tmp = t[i];
        t[i] = t[len-i-1];
        t[len-i-1] = tmp;
    }
    return;
}
EOF
;
}

