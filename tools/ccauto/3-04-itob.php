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
    You can use <b>reverse(s)</b> to reverse a string - make sure you pass a character
    array and not a string constant to <b>reverse</b>.
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
  void itob(), itoh(), reverse();

  itob(42,s);
  printf("42 in base-2 is %s\\n", s);
  itoh(42,s);
  printf("42 in base-16 is %s\\n", s);

  itob(16,s);
  printf("16 in base-2 is %s\\n", s);
  itoh(16,s);
  printf("16 in base-16 is %s\\n", s);

  itob(100,s);
  printf("100 in base-2 is %s\\n", s);
  itoh(100,s);
  printf("100 in base-16 is %s\\n", s);

  itob(64,s);
  printf("64 in base-2 is %s\\n", s);
  itoh(64,s);
  printf("64 in base-16 is %s\\n", s);

}

void reverse(t)
char t[];
{
    int i, j, len;
    char tmp;
    len = strlen(t);
    for(i=0, j=len-1;;i++,j--) {
        if (j<i) break;
        tmp = t[i];
        t[i] = t[j];
        t[j] = tmp;
    }
    return;
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    return <<< EOF
42 in base-2 is 101010
42 in base-16 is 2a
16 in base-2 is 10000
16 in base-16 is 10
100 in base-2 is 1100100
100 in base-16 is 64
64 in base-2 is 1000000
64 in base-16 is 40
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
    strcpy(s,"101010");
}
void itoh(n, s)
int n;
char s[];
{
    strcpy(s,"2a");
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
    int i, sign;
    void reverse();
    i = 0;
    do {    /* generate digits in reverse order */
        s[i++] = n % 2 + '0';     /* get next digit */
    } while ((n /= 2) > 0); /* delete it */
    s[i] = '\\0';
    reverse(s);
}

void itoh(n, s)
int n;
char s[];
{
    int i, sign;
    char digits[] = "01234567890abcdef";
    void reverse();

    i = 0;
    do {    /* generate digits in reverse order */
        s[i++] = digits[n % 16];
    } while ((n /= 16) > 0); /* delete it */
    s[i] = '\\0';
    reverse(s);
}
EOF
;
}

