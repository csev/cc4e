#include <stdio.h>
#include <string.h>
#include <stdlib.h>

extern long __stack_chk_guard;
void bad();

int main() {
    void func();
    printf("__stack_chk_guard %lx\n", __stack_chk_guard);
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
    
    printf("\n");
    lp = ((long *) str) + 3;
    *lp = (long) &bad;

    for(i = 0; i <= 4; i++) {
      lp = ((long *) str) + i; 
      printf("%2d %p %016lx\n",i , lp, *lp);
    }
    printf("func returning...\n");
}

void bad()
{
    printf("IN BAD!\n");
    exit(-1);
}

