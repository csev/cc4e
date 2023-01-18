#include <stdio.h>
#include "point.c"

int main(void)
{
    struct point * p3 = point_new(4,5);
    p3->print(p3);
    p3->del(p3);
}

