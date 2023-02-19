#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int main() {
    void func();
    printf("Before func\n");
    func();
    printf("After func\n");
}

void func()
{
    char str[8] = "hi 42";
    long * lp;
    int i;

    printf("func starting...\n");

    for(i = 0; i <= 4; i++) {
      lp = ((long *) str) + i; 
      printf("%2d %p %016lx\n",i , lp, *lp);
    }
    
    printf("Enter a short string\n");
    gets(&str);

    for(i = 0; i <= 4; i++) {
      lp = ((long *) str) + i; 
      printf("%2d %p %016lx\n",i , lp, *lp);
    }
    printf("func returning...\n");
}

