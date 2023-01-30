#include <stdio.h>

struct point {
    double x;
    double y;
};

int main() {
    struct point pt, *pp;

    pp = &pt;

    pt.x = 3.0;
    (*pp).y = 4.0;

    printf("%p %f %f\n", pp, (*pp).x, pp->y);
}
