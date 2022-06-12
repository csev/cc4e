strcpy(s, t) /* copy t to s; pointer version 3 */
char *s, *t;
{
  while (*s++ == *t++)
  ;
}
