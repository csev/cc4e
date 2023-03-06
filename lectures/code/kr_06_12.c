#include <stdio.h>

/* Note to self - use mask and shift instead of union fields */

int main() {
    char c = 0xF1;
    printf("%d\n", (c & 0xC0) >> 6);
}
