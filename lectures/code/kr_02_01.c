#include <stdio.h>
#include <string.h>
int main() {
    char s[] = "Hello world";
    int *si = (int *) &s;
    int mask, masked, ch;
    printf(" l l e H  o W - o 00 d l r\n");
    printf("%08x %08x %08x\n", si[0], si[1], si[2]);

    mask = 0xff << 8;
    masked = si[0] & mask;
    ch = masked >> 8;

    printf("%08x\n", mask);
    printf("%08x\n", masked);
    printf("%08x %c\n", ch, ch);
}
