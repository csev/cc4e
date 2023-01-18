#include <stdio.h>
#include "point.c"

int main(void)
{
    struct point * pt = point_new(4.0,5.0);
    pt->dump(pt);
    printf("Origin %f\n", pt->origin(pt));
    pt->del(pt);
}

