#include <stdio.h>

#define PS puts

zap() {
putchar('a');
}

main() {
   printf("Hello world\n");
PS("xyz");
zap();
}


