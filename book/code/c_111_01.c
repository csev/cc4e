#include <stdio.h>
#include <string.h>
main(argc, argv) /* echo arguments; 1st version */
int argc;
char *argv[];
{
  int i;

  for (i = 1; i < argc; i++)
    printf("%s%c", argv[i], (i<argc-1) ? ' ' : '\n');
}
