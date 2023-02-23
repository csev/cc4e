#include <stdio.h>
#include <stdlib.h>
#include <math.h>

#include "pointstruct.h"

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

void import_pointstruct() {
     extern struct PointStruct PointClass;

    /* Build the PointClass */
    PointClass.dump = &point_dump;
    PointClass.new = &point_new;
    PointClass.origin = &point_origin;
    PointClass.del = &point_del;
}
