#include <stdio.h>

#define CMASK	0377 /* for making char's > 0 */
#define BUFSIZE 512

getchar() /* buffered version */
{
    static char	buf [BUFSIZE];
    static char	*bufp = buf;
    static int	n = 0;

    if (n == 0) { /* buffer is empty */
        n = read(0, buf, BUFSIZE);
        bufp = buf;
    }
    return((--n >= 0) ? *bufp++ & CMASK : EOF);
}
