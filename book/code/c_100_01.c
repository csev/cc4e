strcpy(s, t) /* copy t to s */
char s[], t[];
{
  int i;

  i = 0;
  while ((s[i] = t[i]) != '\0')
    i++;
}

