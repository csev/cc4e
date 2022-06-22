
/* This file combines three successive sample code segments
   for ease of viewing, editing, and executing */

#include <stdio.h>
#include <string.h>
#define LINES 100 /* max lines to be sorted */

main() /* sort input lines */
{
  char *lineptr[LINES]; /* pointers to text lines */
  int nlines; /* number of input lines read */

  if ((nlines = readlines(lineptr, LINES)) >= 0) {
    sort(lineptr, nlines);
    writelines(lineptr, nlines);
  }
  else
    printf("input too big to sort\n");
}

/* The first example code from page 107 of the text book */

#define MAXLEN 1000

readlines(lineptr, maxlines) /* read input lines */
char *lineptr[]; /* for sorting */
int maxlines;
{
  int len, nlines;
  char *p, *alloc(), line[MAXLEN];

  nlines = 0;
  while ((len = get_line(line, MAXLEN)) > 0)
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

/* The newline at the end of each line is deleted so it 
   will not affect the order in which the lines are sorted. */

/* The second example code from page 107 of the text book */

writelines(lineptr, nlines) /* write output lines */
char *lineptr[];
int nlines;
{
  int i;

  for (i = 0; i < nlines; i++)
    printf("%s\n", lineptr[i]);
}

