#include <stdio.h>

int main() {
    struct point {
        double x;
        double y;
    };

    struct point pt, *pp;

    printf("sizeof pt %ld\n",sizeof(pt));
    printf("sizeof pp %ld\n",sizeof(pp));
    printf("sizeof point %ld\n",sizeof(struct point));
}
