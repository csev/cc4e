<?php

use \Tsugi\Core\LTIX;
use \Tsugi\Util\LTI;
use \Tsugi\Util\PDOX;
use \Tsugi\Util\U;
use \Tsugi\Util\Mersenne_Twister;

// Called first
function ccauto_instructions($LAUNCH) {
    return <<< EOF
<b>Simple Structures</b> 
<p>
You will write two function dealing with a simple strcuture as shown below.

The first function will dump the internal values of the simpledate structure.
The second will compute the day of the year similar to the sample code in
Chapter 6 of the K&amp;R book.
</p>
EOF
;
}

// Make sure to escape \n as \\n
function ccauto_sample($LAUNCH) {
    return <<< EOF
int day_of_year(pd) /* set day of year from month, day */
struct simpledate *pd;
{
    return 42;
}

void dump_date(pd) /* print date from year, month, day */
struct simpledate *pd;
{
    /* The date should be in the following format - note that */
    /* The month and day are always two digits with leading zeros */
    printf("2023/03/07\\n");
}
EOF
;
}

// Remember to double escape \n as \\n
function ccauto_main($LAUNCH) { 
    return <<< EOF
#include <stdio.h>
#include <stdlib.h>

struct simpledate {
    int day;
    int month;
    int year;
};

static int day_tab[2][13] = {
  {0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31},
  {0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31}
};


main() {
    void dump_date();
    printf("Playing with structures\\n");
    struct simpledate sd;

    sd.year = 2023;
    sd.month = 2;
    sd.day = 11;
    dump_date(&sd);
    printf("Day of year %d\\n", day_of_year(&sd));

    sd.year = 2023;
    sd.month = 9;
    sd.day = 15;
    dump_date(&sd);
    printf("Day of year %d\\n", day_of_year(&sd));

    sd.year = 2024;
    sd.month = 9;
    sd.day = 15;
    dump_date(&sd);
    printf("Day of year %d\\n", day_of_year(&sd));
}
EOF
;

}

function ccauto_input($LAUNCH) { return false; }

function ccauto_output($LAUNCH) { 
    GLOBAL $RANDOM_CODE_HOUR, $CHAR_2_10, $LOWER_2_10;
    return <<< EOF
Playing with structures
2023/02/11
Day of year 42
2023/09/15
Day of year 258
2024/09/15
Day of year 259
EOF
;
}

function ccauto_prohibit($LAUNCH) { 
    return array(
        array("main", "Don't include the main() code - the main() code is provided automatically by the autograder."),
        array("extern", "You should not use the 'extern' keyword."),
    );
}

function ccauto_require($LAUNCH) { 
    return array (
        array("%", "This is difficult to do without the modulo operation (%)."),
    );
}

// Make sure to escape \n as \\n
function ccauto_solution($LAUNCH) {
    return <<< EOF
int day_of_year(pd) /* set day of year from month, day */
struct simpledate *pd;
{
    int i, day, leap;

    day = pd->day;
    leap = pd->year % 4 == 0 && pd->year % 100 != 0 || pd->year % 400 == 0;
    for (i = 1; i < pd->month; i++)
        day += day_tab[leap][i];
    return (day);
}

void dump_date(pd) /* print date from year, month, day */
struct simpledate *pd;
{
    printf("%04d/%02d/%02d\\n", pd->year, pd->month, pd->day);
}
EOF
;
}

