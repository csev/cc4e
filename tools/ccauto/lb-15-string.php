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
<b>LBS290 Exercise 15.</b> 
You are to perform the following steps in a function named process():
(1)  Print out the string you are passed.
(2)  Count the number of characters in the string.
(3)  If there are more than 10 characters in the string print out the 10th character (line[9])
(4)  Go through the string and replace every blank with a dash '-'
(5)  Print out the new string with dashes.
<br/>
    <b>Fun Fact:</b>Dr. Chuck used this exact assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn15.txt" target="_blank">LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
#include <string.h>
int main() {
    char line[1000];
    void process();
    strcpy(line,"Hi there and welcome to LBS290");
    process(line);
    strcpy(line,"I love C");
    process(line);
}
EOF
;

}

function ccauto_input($LAUNCH) { 
    return false;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
void process(line)
    char line[];
{
    printf("\\nString: %s\\n",line);
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF

String: Hi there and welcome to LBS290
Count=30
The ninth character is: a
String: Hi-there-and-welcome-to-LBS290

String: I love C
Count=8
String: I-love-C
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
void process(line)
    char line[];
{ 
    int i;
    printf("\\nString: %s\\n",line);
    printf("Count=%d\\n",(int) strlen(line));
    if ( strlen(line) > 10 ) printf("The ninth character is: %c\\n",line[9]);
    for(i=0; line[i]; i++ ) if ( line[i] == ' ' ) line[i] = '-';
    printf("String: %s\\n",line);
}
EOF
;
}

