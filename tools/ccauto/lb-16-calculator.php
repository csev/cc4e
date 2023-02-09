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
<b>LBS290 Exercise 16 - A Calculator.</b> 
In this program you will write a program which simulates a simple
hand calculator which can add, subtract, multiply, and divide floating
point numbers. The calculator program has a display where the answer is
always displayed after each operation is done.  This display is
called the "accumulator" (in computerese).
<pre>
Command         Action

= 1.23          Sets the accumulator to 1.23
+ 5.0           Adds 5.0 to the accumulator
/ 2.0           Divides accumulator by 2.0
* 6.3           Multiplies the accumulator by 6.3
- 4.0           Subtracts 4.0 from the accumulator
S 0.0           Stops the program
</pre>
<b>Fun Fact:</b>Dr. Chuck used this assignment while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn16.txt" target="_blank">LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return false;
}

function ccauto_input($LAUNCH) { 
return <<< EOF
= 6.0
* 7.0
= 1.23
+ 5.0
/ 2.0
* 6.3
- 4.0
EOF;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>

int main()
{
    char line[256];
    char opcode;
    float value, display = 0.0;

    while(fgets(line, 256, stdin) != NULL) {
        if ( line[0] == 'S' ) break;
        sscanf(line, "%c %f", &opcode, &value);

        /* Do something here */

        printf("Display: %.2f\\n", display);
    }
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
Display: 6.00
Display: 42.00
Display: 1.23
Display: 6.23
Display: 3.12
Display: 19.62
Display: 15.62
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('Hello', "Your program should not include 'Hello'"),
        array('world', "Your program should not include 'world'"),
        array('Do something here', 'You have work to do'),
    );
}

function ccauto_require($LAUNCH) { 
    return array(
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) { 
    return <<< EOF
#include <stdio.h>

int main()
{
    char line[256];
    char opcode;
    float value, display = 0.0;

    while(fgets(line, 256, stdin) != NULL) {
        if ( line[0] == 'S' ) break;
        sscanf(line, "%c %f", &opcode, &value);

        /* Do something here */
        if ( opcode == '=' ) display = value;
        else if ( opcode == '+' ) display = display + value;
        else if ( opcode == '-' ) display = display - value;
        else if ( opcode == '*' ) display = display * value;
        else if ( opcode == '/' ) display = display / value;

        printf("Display: %.2f\\n", display);
    }
}
EOF
;
}

