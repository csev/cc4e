#include <stdio.h>
#define MAXLINE 1000

main() /* remove trailing blanks and tabs */
{
  int n;
  char line[MAXLINE];

  while ((n = getline(line, MAXLINE)) > 0) {
    while (--n >= 0)
      if (line[n] != ' ' && line[n] != '\t'
        && line[n] != '\n')
          break;
    line[n+1] = '\0';
    printf("%s\n", line);
  }
}
