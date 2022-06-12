#include <stdio.h>
#include <string.h>
#define MAXLEN 1000

readlines(lineptr, maxlines) /* read input lines */
char *lineptr[]; /* for sorting */
int maxlines;
{
  int len, nlines;
  char *p, *alloc(), line[MAXLEN];

  nlines = 0;
  while ((len = getline(line, MAXLEN)) > 0)
    if (nlines >= maxlines)
      return(-1);
    else if ((p = alloc(len)) == NULL)
      return(-1);
    else {
      line[len-1] = '\0'; /* zap newline */
      strcpy(p, line);
      lineptr[nlines++] = p;
    }
  return (nlines);
}
