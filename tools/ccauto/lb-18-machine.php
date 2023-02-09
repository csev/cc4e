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
<b>LBS290 Exercise 18 - A Simple Machine.</b> 
You are to implement an interpretor for a simple programming language.  Your computer has 256 characters of memory.  You are to
read a sequence of instructions from input and perform those instructions.  At the end of the program you print the
memory out as a zero-terminated C character array.  Here are the instructions you need to support:
<pre>
*           This is a comment, print it out and do no further processing
X           Exit the program (end-of-input also ends the program)
5 = 42      Put the number 42 into memory[5]
10 + 3      Add 3 to the contents of memory[10]
7 - 1       Suptract 1 from the contents of memory[7]
</pre>
All of the numbers should be in the range of 0-255 so they fit into a C char variable.
<br/>
    <b>Fun Fact:</b>Dr. Chuck used an assignment similar to this one while teaching C - <a href="{$CFG->apphome}/archive/1991-lbs290/assn18.txt" target="_blank">LBS 290 - Fall 1991</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return false;
}

function ccauto_input($LAUNCH) { 
return <<< EOF
* Beginning
0 = 72
1 = 101
2 = 108
3 = 108
4 = 108
4 + 3
5 = 10
6 = 100
6 + 19
7 = 111
8 = 114
9 = 108
10 = 101
10 - 1
X
EOF;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>

int main()
{
    char line[256];
    char memory[256];
    char opcode;
    int count,address,value;

    while(fgets(line, 256, stdin) != NULL) {
        printf("\\nLine: %s\\n",line);
        if ( line[0] == 'X' ) break;
        if ( line[0] == '*' ) {
            printf("%s\\n",line);
            continue;
        }
        count = sscanf(line, "%d %c %d", &address, &opcode, &value);
        if ( count != 3 ) continue;
        printf("address: %d opcode: %c value: %d\\n", address, opcode, value);

        /* Do something here */

        printf("Memory:\\n%s\\n", memory);
    }
    printf("Memory:\\n%s\\n", memory);
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
Memory:
Hello
world
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
    char memory[256];
    char opcode;
    int count,address,value;

    while(fgets(line, 256, stdin) != NULL) {
        if ( line[0] == 'X' ) break;
        if ( line[0] == '*' ) {
            printf("%s\\n",line);
            continue;
        }
        if ( debug ) printf("\\nLine: %s\\n",line);
        count = sscanf(line, "%d %c %d", &address, &opcode, &value);
        if ( count != 3 ) continue;

        if ( opcode == '=' ) {
            memory[address] = value;
        } else if ( opcode == '+' ) {
            memory[address] = memory[address] + value;
        } else if ( opcode == '-' ) {
            memory[address] = memory[address] - value;
        }
    }
    printf("Memory:\\n%s\\n", memory);
}

EOF
;
}

