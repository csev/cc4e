#include <stdio.h>
#include <stdlib.h>
#include <string.h>
int main() {
    int first = 1;
    int val, maxval, minval;
    char line[1000];

    while(gets(line) != NULL ) {
        if ( strcmp(line,"done") == 0 ) break;
        val = atoi(line);
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
