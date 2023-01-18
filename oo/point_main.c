#include <stdio.h>
#include "point.c"

int main(void)
{
    struct point * pt = point_new(4.0,5.0);
    point_dump(pt);
    printf("Origin %f\n", point_origin(pt));
    point_del(pt);
}

