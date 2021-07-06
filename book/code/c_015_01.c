#include <stdio.h>

main() /* copy input to output; 2nd version */
{
    int c;
    while ((c = getchar()) != EOF)
        putchar(c);
}
