#include <stdio.h>
void semifunc(x) 
    int x;
{
    if ( x == 21 ) {
        x = x + 1;
        x = x / 2;
    }
    printf("%d\n",x);
}
