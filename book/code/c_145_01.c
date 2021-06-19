#include <stdio.h>
#include <ctype.h>

main() /* convert input to lower case */
{
    int c;

    while ((c = getchar()) != EOF)
        putchar(isupper(c) ? tolower(c) : c);
}

