/* https://www.geeksforgeeks.org/function-pointer-in-c/ */

#include <stdio.h>
  
int main()
{
    // fun_ptr is a pointer to function fun() 
    void (*fun_ptr)(const char *) = &puts;
  
    // Invoking fun() using fun_ptr
    (*fun_ptr)("Yada");
  
    return 0;
}

