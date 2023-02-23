#include <stdio.h>
#include <stdlib.h>
#include <math.h>

#include "pointstruct.h"

int main(void)
{
    IMPORT_POINT;

    struct point * pt = PointClass.new(4.0,5.0);
    PointClass.dump(pt);
    printf("Origin %f\n", PointClass.origin(pt));
    PointClass.del(pt);
}

