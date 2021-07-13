/* https://www.geeksforgeeks.org/function-pointer-in-c/ */

#include <stdio.h>
  
int main()
{
    void (*fun_ptr)(const char *) = &puts;
  
    (*fun_ptr)("Yada");
  
    return 0;
}

