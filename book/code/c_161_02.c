
#include <stdio.h>

#define CMASK	0377 /* for making char's > 0 */
getchar() /* unbuffered single character input */
{
    char c;
    return((read(0, &c, 1) > 0) ? c & CMASK : EOF);
}

