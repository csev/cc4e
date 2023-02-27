#include <stdio.h>
#include <stdlib.h>
#include <math.h>

struct point
{
    double x;
    double y;
};

void point_dump(const struct point* self)
{
    printf("Object point@%p x=%f y=%f\n", 
            self, self->x, self->y);
}

void point_del(const struct point* self) {
  free((void *)self);
}

double point_origin(const struct point* self) {
    return sqrt(self->x*self->x + self->y*self->y);
}

struct point * point_new(double x, double y) {
    struct point *p = malloc(sizeof(*p));
    p->x = x;
    p->y = y;
    return p;
}

int main(void)
{
    struct point * p1 = point_new(4.0,5.0);
    point_dump(p1);
    printf("Origin %f\n", point_origin(p1));
    point_del(p1);
}

