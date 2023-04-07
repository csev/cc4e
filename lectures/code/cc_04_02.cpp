#include <iostream>
#include <math.h>

class Point {
  public: 
    double x, y;

    Point(double xc, double yc)  {
        x = xc;
        y = yc;
    };

    void dump() {
        printf("Object point x=%f y=%f\n", x, y);
    }

    double origin() {
        return sqrt(x*x+y*y);
    }
};

int main() {
    Point pt(4.0, 5.0);
    pt.dump();
    printf("Origin: %f\n", pt.origin());
}

// rm -f a.out; g++ cc_03_01.cpp; a.out; rm -f a.out

