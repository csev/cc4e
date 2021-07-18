#include<stdio.h>
#include<string.h>
#define MAXLINE 1000

main(argc, argv) /* find pattern from first argument */
int argc;
char *argv[];
{
  char line[MAXLINE];

  if (argc != 2)
    printf("Usage: find pattern\n");
  else
    while (get_line(line, MAXLINE) > 0)
      if (index(line, argv[1]) >= 0)
        printf("%s", line);
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
