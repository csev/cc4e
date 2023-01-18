#include <stdio.h>
#include <stdlib.h>
#include <math.h>

struct point
{
    double x;
    double y;
    void (*del)(const struct point*);
    void (*dump)(const struct point*);
    double (*origin)(const struct point*);
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
    p->del = point_del;
    p->dump = point_dump;
    p->origin = point_origin;
    return p;
}

