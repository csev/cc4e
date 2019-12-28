#include "point.c"

int main(void)
{
    struct point * p3 = point_new(4,5);
    p3->print(p3);
    p3->del(p3);
}

/* https://stackoverflow.com/questions/12642830/can-i-define-a-function-inside-a-c-structure/12642878#12642878 */

