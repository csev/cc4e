#define MAXLINE 1000

main() /* find all lines matching a pattern */
{
  char line[MAXLINE];

  while (get_line(line, MAXLINE) > 0)
    if (index_(line, "the") >= 0)
      printf("%s", line);
}

get_line(s, lim) /* get line into s, return length */
char s[];
int lim;
{
    int c, i;

    for (i=0; i<lim-1 && (c=getchar())!=EOF && c!='\n'; ++i)
        s[i] = c;
    if (c == '\n') {
        s[i] = c;
        ++i;
    }
    s[i] = '\0';
    return(i);
}


index_ (s, t) /* return index of t in s, -1 if none */
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
