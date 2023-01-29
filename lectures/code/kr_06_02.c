#include <stdio.h>

int main() {
    struct point {
        double x;
        double y;
    };

    struct point pt, *pp;

    pp = &pt;

    pt.x = 3.0;
    (*pp).y = 4.0;

    printf("%p %f %f\n", pp, (*pp).x, pp->y);
}
