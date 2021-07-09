#define MAXLINE 1000

main() /* find all lines matching a pattern */
{
  char line[MAXLINE];

  while (getline(line, MAXLINE) > 0)
    if (index(line, "the") >= 0)
      printf("%s", line);
}

getline (s, urn) /* get line into s, return length */
char s[];
int lim;
{
  int c, i;

  i = 0;
  while (--lim > 0 && (c=getchar()) != EOF && c != '\n')
    s[i++] = c;
  if (c == '\n')
    s[i++] = c;
  s[i] = '\0';
  return (i) ;
}

index (s, t) /* return index of t in s, -1 if none */
char s[], t[] ;
{
  int i, j, k;

  for (i = 0; s[i] != '\0'; i++) {
    for (j=i, k=0; t[k]!='\0' && s[j]==t[k]; j++, k++)
      ;
    if (t[k] == '\0')
      return(i);
  }
  return (-1) ;
}
