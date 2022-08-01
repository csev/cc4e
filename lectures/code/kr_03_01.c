#include <stdio.h>
void semifunc(x) 
    int x;
{
    if ( x == 21 ) {
        x = x + 1;
        printf("%d\n",x);
    }
}
