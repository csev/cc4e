#include <stdio.h>

int main() {
    struct point {
        double x;
        double y;
    };

    struct point pt, *pp;

    pt.x = 3.0;
    pt.y = 4.0;

    pp = &pt;

    printf("%p %f %f\n", pp, (*pp).x, pp->y);

    printf("sizeof pt %ld\n",sizeof(pt));
    printf("sizeof pp %ld\n",sizeof(pp));
    printf("sizeof point %ld\n",sizeof(struct point));
}
