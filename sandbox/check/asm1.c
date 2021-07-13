#include <stdio.h>

main() {
    asm("mov r0,r0");
    __asm__("mov r0,r0");
    puts("Yada");
}
