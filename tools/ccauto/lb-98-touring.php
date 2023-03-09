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
<b>LBS290 Exercise 98 - A Touring Machine.</b> 
This is a subset of an important concept in Computer Science called a
<a href="https://en.wikipedia.org/wiki/Turing_machine" target="_blank">Turing Machine</a>.
We call it a "Touring Machine" because
it "wanders around and does things in memory" similar to a Turing Machine.
Your computer has 256 characters of memory.  
The machine keeps track of the "position" or the "head" where data is to be written.  The starting position is zero.
You are to read a sequence of instructions from input and perform those instructions.  When there are no more instructions,
print the memory out as a zero-terminated C character array.  Here are the instructions you need to support:
<pre>
42     Store this value into the memory at the current position
>      Move the "position" one to the right (i.e. position++);
<      Move the "position" one to the left (i.e. position--);
</pre>
All of the numbers should be in the range of 0-255 so they fit into a C char variable.
<br>
<b>Fun Fact:</b> Dr. Chuck did <b>not</b> assign this question in 1991.  But if time travel were possible, he
would consider adding it to <a href="{$CFG->apphome}/archive/1991-lbs290/" target="_blank">LBS 290</a>.
EOF
;
}

function ccauto_main($LAUNCH) { 
    return false;
}

function ccauto_input($LAUNCH) { 
return <<< EOF
42 > 114 > 105 > 97 > 
110 < < < < 66
EOF;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
#include <stdio.h>

int main()
{
    char memory[256], token[256];
    int position = 0, value;

    while(scanf("%s",token) == 1 ) {
        printf("%s\\n",token);

        /* Replace this with your code */
    }
    printf("Memory:\\n%s\\n", memory);
}
EOF
;
}

function ccauto_output($LAUNCH) { 
    return <<< EOF
Memory:
Brian
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array('Brian', "Your program should not include 'Brian'"),
        array('Replace this with your code', 'Remove the placeholder comment'),
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
    char memory[256], token[256];
    int position = 0, value;

    while(scanf("%s",token) == 1 ) {
        if ( token[0] == '>' ) position++;
        else if ( token[0] == '<' ) position--;
        else if ( sscanf(token, "%d", &value) == 1 ) memory[position] = value;
    }
    printf("Memory:\\n%s\\n", memory);
}
EOF
;
}

