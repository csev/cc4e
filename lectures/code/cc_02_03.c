#include <stdio.h>
int main() {
    char name[101];
    printf("Enter name\n");
    scanf("%100s", name);
    printf("Hello %s\n", name);
}

