#include<stdio.h>
#include<string.h>
#define NULL 0
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

writelines(lineptr, nlines) /* write output lines */
char *lineptr[];
int nlines;
{
  int i;

  for (i = 0; i < nlines; i++)
    printf("%s\n", lineptr[i]);
}

sort(v, n) /* sort strings v[0] v[n-1] */
char *v[]; /* into increasing order */
int n;
{
  int gap, i, j;
  char *temp;

  for (gap = n/2; gap > 0; gap /= 2)
    for (i = gap; i < n; i++)
      for (j = i-gap; j >= 0; j -= gap) {
        if (strcmp(v[j], v[j+gap]) <= 0)
          break;
        temp = v[j];
        v[j] = v[j+gap];
        v[j+gap] = temp;
      }
}

get_line(s, lim) /* get line into s, return length */
char s[];
int lim;
{
    int c, i;

    for (i=0; i<lim-1 && (c=getchar())!=EOF && c!='\n'; ++i)
        s[i] = c;
    if (c == '\n') {
        s[i] = c;
        ++i;
    }
    s[i] = '\0';
    return(i);
}
