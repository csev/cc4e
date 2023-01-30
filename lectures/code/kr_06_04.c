#include <stdio.h>

struct point {
    double x;
    double y;
};

void func(pp) 
    struct point *pp;
{
    pp->x = 9.0;
    pp->y = 8.0;
    printf("func %f %f\n", pp->x, pp->y);
}

int main() {
    struct point pm;

    pm.x = 3.0;
    pm.y = 4.0;

    printf("main %f %f\n", pm.x, pm.y);
    func(&pm);
    printf("back %f %f\n", pm.x, pm.y);
}

