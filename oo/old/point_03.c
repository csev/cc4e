#include <stdio.h>
#include <stdlib.h>
#include <math.h>

#include "pointstruct.h"

int main(void)
{
    IMPORT_POINT;

    struct point * p1 = PointClass.new(4.0,5.0);
    PointClass.dump(p1);
    printf("Origin %f\n", PointClass.origin(p1));
    PointClass.del(p1);
}

