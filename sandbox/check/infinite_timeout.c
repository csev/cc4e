#include <stdio.h>

/* about five seconds */

main() {
    long value = 1;
    long i,j,k;

    for(i=0;i<1000000;i++) 
        for(j=0;j<600;j++) 
                value = (value * 22) % 7;

    printf("Value=%ld\n", value);
}
