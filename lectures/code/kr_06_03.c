#include <stdio.h>
#include <stdlib.h>

int main() {
    struct point {
        double x;
        double y;
    };

    struct point *pp;

    pp = (struct point *) malloc(sizeof(struct point));

    pp->x = 3.0;
    (*pp).y = 4.0;

    printf("%p %f %f\n", pp, (*pp).x, pp->y);

    printf("sizeof pp %ld\n",sizeof(pp));
    printf("sizeof point %ld\n",sizeof(struct point));

}
