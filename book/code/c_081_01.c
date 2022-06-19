#include <stdio.h>

/* Exploring the register keyword in modern compilers
 *
 * to compile on a Unix style system use the command:
 *
 * gcc -S n_081_01.c
 *
 * and compare the contents of the n_081_01.s files with and without
 * the register keyword.
 */

int main() {
    
    int compute;
    register int iter;

    scanf("%d", &compute);
    printf("compute %d\n", compute);
    for(iter=0; iter<1000; iter++) {
        compute = (compute * 22) * 7;
        if ( compute > 1000 ) compute = compute % 1000;
    }   
    printf("compute %d\n",compute);
} 

