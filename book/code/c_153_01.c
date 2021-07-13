#include <stdio.h>

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
        printf("cat: can't open %s\n", *argv);
        break;
      } else {
        filecopy(fp);
        fclose(fp);
      }
}

filecopy(fp) /* copy file fp to standard output */
FILE *fp;
{
  int c;

  while ((c = getc(fp)) != EOF)
    putc(c, stdout);
}
