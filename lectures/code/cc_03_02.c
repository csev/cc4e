#include <stdio.h>
#include <stdlib.h>
#include <math.h>

struct point
{
    double x;
    double y;
};

struct PointStruct {
    double x;
    double y;

    struct PointStruct * (*new)(double x, double y);
    void (*del)(const struct PointStruct* self);
    void (*dump)(const struct PointStruct* self);
    double (*origin)(const struct PointStruct* self);
};

void point_dump(const struct PointStruct* self)
{
    printf("Object point@%p x=%f y=%f\n", 
            self, self->x, self->y);
}

void point_del(const struct PointStruct* self) {
  free((void *)self);
}

double point_origin(const struct PointStruct* self) {
    return sqrt(self->x*self->x + self->y*self->y);
}

struct PointStruct * point_new(double x, double y) {
    struct PointStruct *p = malloc(sizeof(*p));
    p->x = x;
    p->y = y;
    p->dump = &point_dump;
    p->new = &point_new;
    p->origin = &point_origin;
    p->del = &point_del;
    return p;
}

struct PointStruct PointClass;

void import_PointClass() {
    PointClass.dump = &point_dump;
    PointClass.new = &point_new;
    PointClass.origin = &point_origin;
    PointClass.del = &point_del;
}

int main(void)
{
    import_PointClass();

    struct PointStruct * pt = PointClass.new(4.0,5.0);
    PointClass.dump(pt);
    printf("Origin %f\n", pt->origin(pt));
    PointClass.del(pt);
}

