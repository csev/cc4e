#include <stdio.h>
#include <string.h>
#define LINES 100 /* max number of lines to be sorted */

main(argc, argv) /* sort input lines */
int argc;
char *argv[];
{
  char *lineptr[LINES]; /* pointers to text lines */
  int nlines; /* number of input lines read */
  int strcmp(), numcmp(); /* comparison functions */
  int swap(); /* exchange function */
  int numeric = 0; /* 1 if numeric sort */

  if (argc>1 && argv[1][0] == '-' && argv[1][1] == 'n')
    numeric = 1;
  if ((nlines = readlines(lineptr, LINES)) >= 0) {
    if (numeric)
      sort(lineptr, nlines, numcmp, swap);
    else
      sort(lineptr, nlines, strcmp, swap);
    writelines(lineptr, nlines);
  } else
      printf("input too big to sort\n");
}
