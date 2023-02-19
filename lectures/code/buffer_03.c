#include <stdio.h>
#include <string.h>

int main() {
    int func();

    func("Bob");
    func("xxxxxx");
}

int func(str) 
    char *str;
{
    char one[] = "Hello";

    printf("%s\n", one);
    strcpy(one, str);
    printf("%s\n", one);
}
