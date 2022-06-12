#include <stdio.h>

printd(n) /* print n in decimal */
int n;
{
  char s[10];
  int i;

  if (n < 0) {
    putchar('-');
    n = -n;
  }
  i = 0;
  do {
        s[i++]  = n % 10  + '0';  /* get next char  */
  } while ((n  /= 10) >  0); /*  discard it */
  while (--i >= 0)
    putchar(s[i]);
}
