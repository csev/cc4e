#include <stdio.h>

char *f_gets(s, n, iop) /* get at most n chars from iop */
char *s;
int n;
register FILE *iop;
{
  register int c;
  register char *cs;

  cs = s;

  while (--n > 0 && (c = getc(iop)) != EOF)
    if ((*cs++ = c) == '\n')
      break;
  *cs = '\0';
  return((c == EOF && cs == s) ? NULL : s);
}

f_puts(s, iop) /* put string s on file iop */
register char *s;
register FILE *iop;
{
  register int c;

  while (c = *s++)
    putc(c, iop);
}
