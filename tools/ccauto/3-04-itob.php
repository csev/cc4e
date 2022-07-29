<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>K&R Exercise 3-4.</b> 
    <p>
    Write a function <b>itob(n, s)</b> which converts the unsigned integer n into a
    binary (base 2) character representation in s. 
    Write <b>itoh<b>, which converts an integer to hexadecimal representation.
    You can assume
    that the <b>s</b> variable contains enough space.  Make sure to properly terminate
    <b>s</b> with the end-of-string marker '\\0' before returning.
    </p>
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
int main() {
  char s[1000];
  void itob(), itoh();
  printf("YADA\\n");
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    return <<< EOF
Hello world
Hello world\\n
Hello\\tworld\\n
Hello\\tworld\\nHave a nice\\tday\\n
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void expand(s, t)
char s[], t[];
{
  int i, j;
  for(i=0, j=0; s[i]; i++) {
    t[j++] = s[i];
  }
  t[j] = '\\0';
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('else', 'You are to use a switch statement, not an if-then-else.'),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array('switch', 'You need to use a switch statement - it is a short switch statement but we need to assess an important learning objective :)'),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
void expand(s, t)
char s[], t[];
{
  int i, j;
  for(i=0, j=0; s[i]; i++) {
    switch(s[i]) {
    case '\\n':
        t[j++] = '\\\\';
        t[j++] = 'n';
        break;
    case '\\t':
        t[j++] = '\\\\';
        t[j++] = 't';
        break;
    default:
        t[j++] = s[i];
    }
  }
  t[j] = '\\0';
}
EOF
;
}

