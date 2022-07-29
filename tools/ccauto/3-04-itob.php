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
    Write <b>itoh</b>, which converts an integer to hexadecimal representation.
    You can assume
    that the <b>s</b> variable contains enough space.  Make sure to properly terminate
    <b>s</b> with the end-of-string marker '\\0' before returning.
    </p>
    <p>
    You can use <b>strrev(s)</b> to reverse a string - make sure you pass a character
    array and not a string constant to <b>strrev</b>.
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
  char s[1000];
  void itob(), itoh();
  strcpy(s, "YADA");
  printf("YADA %s\\n", s);
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
void itob(n, s)
int n;
char s[];
{
    strcpy(s,"42");
}
void itoh(n, s)
int n;
char s[];
{
    strcpy(s,"28");
}
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
    );
}

function ccauto_require($LAUNCH) { 
    return array (
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
void itob(n, s)
int n;
char s[];
{
    strcpy(s,"42");
}
void itoh(n, s)
int n;
char s[];
{
    strcpy(s,"28");
}
EOF
;
}

