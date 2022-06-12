#include <stdio.h>
#include <string.h>
main(argc, argv) /* echo arguments; 2nd version */
int argc;
char *argv[];
{
  while (--argc > 0)
    printf("%s%c", *++argv, (argc > 1) ? ' ' : '\n');
}
