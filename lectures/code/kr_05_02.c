#include <stdio.h>

int main() {
    char ca[10], *cp;
    int ia[10], *ip;

    cp = ca + 1;
    ip = ia + 1;
    printf("ca %p cp %p\n", ca, cp);
    printf("ia %p ip %p\n", ia, ip);
}

