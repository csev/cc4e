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
