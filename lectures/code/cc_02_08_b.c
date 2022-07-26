#include <stdio.h>

int main() {
    int first = 1;
    int val, maxval, minval;

    while(scanf("%d",&val) != EOF ) {
        if ( first ) {
            maxval = val;
            minval = val;
            first = 0;
        } else {
            if ( val > maxval ) maxval = val;
            if ( val < minval ) minval = val;
        }
    }
        
    printf("Maximum %d\n", maxval);
    printf("Minimum %d\n", minval);
}
