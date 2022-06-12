int strlen(s) /* return length of string s */
char *s;
{
  int n;

  for (n = 0; *s != '\0'; s++)
    n++;
  return (n);
}
