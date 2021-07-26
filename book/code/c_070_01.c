#include <stdio.h>
#define MAXLINE 100

main() /* rudimentary desk calculator */
{
  double sum, atof();
  char line[MAXLINE];

  sum = 0;
  while (get_line(line, MAXLINE) > 0)
    printf("\t%.2f\n", sum += atof (line));
}
