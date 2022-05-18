#include <stdio.h>
#include <string.h>
#define MAXLINE 1000

main(argc, argv) /* find pattern from first argument */
int argc;
char *argv[];
{
  char line[MAXLINE], *s;
  long lineno = 0;
  int except = 0, number = 0;

  while (--argc > 0 && (*++argv)[0] == '-')
    for (s = argv[0]+1; *s != '\0'; s++)
      switch (*s) {
      case 'x':
        except = 1;
        break;
      case 'n':
        number = 1;
        break;
      default:
        printf("find: illegal option %c\n", *s);
        argc = 0;
        break;
      }
  if (argc != 1)
    printf("Usage: find -x -n pattern\n");
  else
    while (getline(line, MAXLINE) > 0) {
      lineno++;
      if ((index(line, *argv) >= 0) != except) {
        if (number)
          printf("%ld: ", lineno);
        printf("%s", line);
        }
    }
}
