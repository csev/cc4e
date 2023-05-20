#include <stdio.h>
int main() {
    char x[] = "Hello";
    int py_len();
    printf("%s %d\n",x, py_len(x));
}
int py_len(self) 
    char self[];
{
    int i;
    for(i=0;self[i]; i++);
    return i;
}

/* rm a.out ; gcc kr_01_05.c ; a.out ; rm a.out */
