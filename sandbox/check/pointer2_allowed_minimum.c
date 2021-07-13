/* https://www.geeksforgeeks.org/function-pointer-in-c/ */

#include <stdio.h>
  
extern system;

int main()
{
    void (*fun_ptr)(const char *) = &system;
  
    (*fun_ptr)("Yada");
  
    return 0;
}

