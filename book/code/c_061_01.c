#include <stdio.h>
#define MAXLINE 1000

main() /* remove trailing blanks and tabs */
{
  int n;
  char line[MAXLINE];

  while ((n = get_line(line, MAXLINE)) > 0) {
    while (--n >= 0)
      if (line[n] != ' ' && line[n] != '\t'
        && line[n] != '\n')
          break;
    line[n+1] = '\0';
    printf("%s\n", line);
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
