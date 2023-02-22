#include <stdio.h>
#include <string.h>

int main() {
    union sample {
        int i;
        char ca[4];
        float f;
    } ;

    union sample u;

    u.i = 42;
    printf("%08x %f %s\n", u.i, u.f, u.ca);

    strcpy(u.ca, "Abc");
    printf("%08x %f %s\n", u.i, u.f, u.ca);

    u.f = 1.0/3.0;
    printf("%08x %f %s\n", u.i, u.f, u.ca);
}
