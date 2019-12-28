#include <stdio.h>
#include <stdlib.h>

struct point
{
    int x;
    int y;
    int (*add)(const struct point*);

    void (*str)(const struct point*);
    void (*del)(const struct point*);
};

void point_str(const struct point* self)
{
    printf("x=%d\n", self->x);
    printf("y=%d\n", self->y);
}

int point_add(const struct point* self)
{
    return (self->x + self->y);
}

void point_del(const struct point* self) {
  free((void *)self);
}

struct point * point_new(int x, int y) {
    struct point *p = malloc(sizeof(*p));
    p->x = x;
    p->y = y;
    p->add = point_add;
    p->str = point_str;
    p->del = point_del;
    return p;
}

/* https://stackoverflow.com/a/59509251/1994792 */
/* https://stackoverflow.com/questions/12642830/can-i-define-a-function-inside-a-c-structure/12642878#12642878 */
