#include <stdlib.h>

strsave(s) /* save string s somewhere */
{
  char *p;

  if ((p = alloc(strlen(s)+1)) != NULL)
    strcpy(p, s);
  return(p);
}

