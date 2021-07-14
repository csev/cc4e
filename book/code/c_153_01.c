#include <stdio.h>

main(argc, argv) /* cat: concatenate files */
int argc;
char *argv[];
{
  FILE *fp, *fopen();

  if (argc == 1) /* no args; copy standard input */
    file_copy(stdin);
  else
    while (--argc > 0)
      if ((fp = fopen(*++argv, "r")) == NULL) {
        printf("cat: can't open %s\n", *argv);
        break;
      } else {
        file_copy(fp);
        fclose(fp);
      }
}

file_copy(fp) /* copy file fp to standard output */
FILE *fp;
{
  int c;

  while ((c = getc(fp)) != EOF)
    putc(c, stdout);
}
