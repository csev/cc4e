#include <stdio.h>
int main() {
    char x[] = "Hello";
    int py_len();
    printf("%s %d\n",x, py_len(x));
}
int py_len(self) 
    char self[];
{
    int i, len=0;
    for(i=0;self[i]; i++) len=i;
    return i;
}
