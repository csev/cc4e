writelines(lineptr, nlines) /* write output lines */
char *lineptr[];
int nlines;
{
  while (--nlines >= 0)
    printf("%s\n", *lineptr++);
}
