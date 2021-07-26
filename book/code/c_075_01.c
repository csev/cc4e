#include <stdio.h>
#define MAXVAL 100 /* maximum depth of val stack */

int sp = 0; /* stack pointer */
double val[MAXVAL]; /* value stack */

double push(f) /* push f onto value stack */
double f;
{
  if (sp < MAXVAL)
    return(val[sp++] = f);
  else {
    printf("error: stack full\n");
    clear();
    return(0);
  }
}

double pop() /* pop top value from stack */
{
  if (sp > 0)
    return(val[--sp]);
  else {
    printf("error: stack empty\n");
    clear();
    return(0);
  }
}

clear() /* clear stack */
{
  sp = 0;
}
