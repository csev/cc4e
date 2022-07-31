#include <stdio.h>
int main() {
    char x[3] = "Hi";
    char y[3] = { 'H', 'i' };
    printf("x %s\n", x);
    printf("y %s\n", y);
    printf("%s\n", "Hi");
    printf("%c%c\n", 'H', 'i');
}
