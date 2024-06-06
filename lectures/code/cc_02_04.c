#include <stdio.h>
int main() {
    char line[1001];
    printf("Enter line\n");
    scanf("%1000[^\n]s", line);
    printf("Line: %s\n", line);
}

