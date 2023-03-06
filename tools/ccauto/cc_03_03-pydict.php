<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Python String Class</b> 
<p>
    You will a set of supporting functions using the following structure
    to implement a subset of the Python list class in C.  Some code and
    method signatures have been provided for you as well as a main() program
    and some support routines from the lecture slides.  
    There is a good deal of discussion of this application in the lecture
    materials associtate with this assignment.
<pre>
struct pystr
{
    int length;
    int alloc; /* the length of *data */
    char *data;
};
</pre>
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Pystr length=0 alloc=10 data=
Pystr length=1 alloc=10 data=H
Pystr length=11 alloc=20 data=Hello world
String = A completely new string
Length = 23
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        // array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        // array("extern", "You should not use the 'extern' keyword."),
        // array("[", "You do not need to use any arrays []."),
        // array("]", "You do not need to use any arrays []."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        // array("malloc", "You need to use malloc() to allocate some memory."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
EOF
;
}

