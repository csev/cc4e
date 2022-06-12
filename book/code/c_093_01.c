#include <stdio.h>

get_int(pn) /* get next integer from input */
int *pn;
{
  int c, sign;

  while ((c = getch()) == ' ' || c == '\n' || c == '\t')
  ;   /* skip white space */
  sign = 1;
  if (c == '+' || c == '-') { /* record sign */
    sign = (c=='+') ? 1 : -1;
    c = getch();
  }
  for (*pn = 0; c >= '0' && c <= '9'; c = getch())
    *pn = 10 * *pn + c - '0';
  *pn *= sign;
  if (c != EOF)
    ungetch(c);
  return(c);
}

