#include <stdio.h>
#include <string.h>
#define MAXLINE 1000

main(argc, argv) /* find pattern from first argument */
int argc;
char *argv[];
{
  char line[MAXLINE];

  if (argc != 2)
    printf("Usage: find pattern\n");
  else
    while (getline(line, MAXLINE) > 0)
      if (index(line, argv[1]) >= 0)
        printf("%s", line);
}
