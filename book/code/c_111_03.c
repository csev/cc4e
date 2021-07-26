#include<stdio.h>
#include<string.h>
main(argc, argv) /* echo arguments; 3rd version */
int argc;
char *argv[];
{
  while (--argc > 0)
    printf((argc > 1) ? "%s " : "%s\n", *++argv);
}
