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
<b>LBS290 Exercise 14.</b> 
The program will create a 10 element array and read in 10 integers
into the array.  Then the program will print the integers backwards.
Then the program will scan for entries in the array which contain the
value 100 and print out the index of the entries with the number 100.
The program will also count the number of entries which equal 100.
The program should work even if there are no entries which equal 100.  
See the sample output for the expect format of the output.
<br/>
    <b>Fun Fact:</b>Dr. Chuck used this exact assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn14.txt" target="_blank">LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return false;
}

function ccauto_input($LAUNCH) { 
    return <<< EOF
9
5
100
16
18
20
6
100
1
77
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>
int main() {
   int i, v, arr[10];
   for(i=0;i<10;i++) {
       scanf("%d", &v);
       arr[i] = v;
   }
   for(i=0; i<10; i++ ) printf("Output %d\\n",arr[i]);
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
numb[9] = 77
numb[8] = 1
numb[7] = 100
numb[6] = 6
numb[5] = 20
numb[4] = 18
numb[3] = 16
numb[2] = 100
numb[1] = 5
numb[0] = 9

Searching for entries equal to 100

Found 100 at 2
Found 100 at 7

Found 2 entries with 100
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('77', "Read the input"),
    );
}

function ccauto_require($LAUNCH) { 
    return array(
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { 
	return <<< EOF
EOF
;
}

