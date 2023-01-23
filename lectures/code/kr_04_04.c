#include <stdio.h>

#ifdef USE_LONG
#define INT_32 long
#else
#define INT_32 int
#endif

int main() {

    int i;
    INT_32 ipaddress;

    // ...
}

