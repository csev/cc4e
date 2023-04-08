#include <iostream>
#include <math.h>

class Point {
  private: 
    double x, y;

  public: 
    Point(double xc, double yc)  {
        x = xc;
        y = yc;
    };

    void dump() {
        printf("Object point x=%f y=%f\n", x, y);
    }
};

int main() {
    Point pt(4.0, 5.0);
    pt.dump();
}

// rm -f a.out; g++ cc_04_00a.cpp; a.out; rm -f a.out

