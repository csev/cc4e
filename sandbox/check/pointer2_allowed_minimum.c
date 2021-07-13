/* https://www.geeksforgeeks.org/function-pointer-in-c/ */

#include <stdio.h>
  
extern int system();

int main()
{
    void (*fun_ptr)(int) = &system;
  
    (*fun_ptr)("Yada");
  
    return 0;
}

