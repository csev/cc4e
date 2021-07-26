#include <stdio.h>
#include <stdlib.h>

main(argc, argv) /* cat: concatenate files */
int argc;
char *argv[];
{
  FILE *fp, *fopen();

  if (argc == 1) /* no args; copy standard input */
    filecopy(stdin);
  else
    while (--argc > 0)
      if ((fp = fopen(*++argv, "r")) == NULL) {
        fprintf(stderr,
          "cat: can't open %s\n", *argv);
        exit (1);
      } else {
        filecopy(fp);
        fclose(fp);
      }
  exit (0);
}
