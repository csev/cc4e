#include <stdio.h>

int main() {
    int x, y;
    void func();

    x = 42;
    y = 43;
    printf("main x=%d y=%d\n", x, y);
    func(x, &y);
    printf("back x=%d y=%d\n", x, y);
}

void func(a, pb)
    int a, *pb;
{
    a = 1;
    *pb = 2;
}

