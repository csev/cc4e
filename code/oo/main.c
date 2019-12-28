#include <stdio.h>
#include "point.c"

int main(void)
{
    struct point * p3 = point_new(4,5);
    p3->str(p3);
    printf("Added=%d\n",p3->add(p3));
    p3->del(p3);
}


