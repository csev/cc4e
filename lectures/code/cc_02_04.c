#include <stdio.h>
int main() {
    char line[1000]; /* Warning */
    printf("Enter line\n");
    scanf("%[^\n]s", line);
    printf("Line: %s\n", line);
}

