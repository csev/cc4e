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

struct PointStruct {
    struct point * (*new)(double x, double y);
    void (*del)(const struct point* self);
    void (*dump)(const struct point* self);
    double (*origin)(const struct point* self);
};

struct PointStruct PointClass;

void import_PointClass() {
    /* Build the Point class */
    PointClass.dump = &point_dump;
    PointClass.new = &point_new;
    PointClass.origin = &point_origin;
    PointClass.del = &point_del;
}

int main(void)
{
    import_PointClass();

    struct point * pt = PointClass.new(4.0,5.0);
    PointClass.dump(pt);
    printf("Origin %f\n", PointClass.origin(pt));
    PointClass.del(pt);
}

