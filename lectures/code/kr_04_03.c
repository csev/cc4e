#include <stdio.h>

int sumup(int above)
{
    int below;
    int sum;
    int retval;

    printf("In: %d\n",above);
    if ( above <= 1 ) return 1; // Stop 
    below = above - 1; 
    printf("Down: %d\n",below);
    sum = sumup(below);         // Recurse
    printf("Back: %d\n",sum);
    retval = above + sum;
    printf("Up: %d\n",retval);
    return retval;
}

int main()
{
    int sup = sumup(3);
    printf("Sup: %d\n",sup);
}
