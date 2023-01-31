<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    global $CFG;
    return <<< EOF
<p>
<b>LBS290 Exercise 13.</b> 
This program will read an un-specified number of employee time
records from input.  Each time record will contain an employee number
(integer), an employee rate per hour (float) and number of hours
worked.
You must write a function named <b>calcpay()</b> to calculate the pay.
The function should have no
return value and must not use any global variables.  The calculated pay
should be passed out of the function using call by location.
<br/>
    <b>Fun Fact:</b>Dr. Chuck used this exact assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn13.txt" target="_blank"> in LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
main() {
  int empno;
  float rate;
  float hours;
  float pay;
  void calcpay();

  while(1) {
    if ( scanf("%d %f %f",&empno,&rate,&hours) < 3 ) break;
    calcpay(&pay, rate, hours);
    printf("Employee=%d Rate=%.2f Hours=%.2f Pay=%.2f\\n",empno, rate, hours, pay);
  } 
}
EOF
;
}

function ccauto_input($LAUNCH) { 
    return <<< EOF
123 5.00 40
100 4.00 45
199 5.25 10
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void calcpay(p,r,h)
    float *p,r,h;
{

}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
Yada
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
    );
}

function ccauto_require($LAUNCH) { 
    return array(
        array('.5;', "Time and a half for over time :)."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { return false; }

