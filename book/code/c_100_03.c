strcpy(s, t) /* copy t to s; pointer version 2 */
char *s, *t;
{
  while ((*s++ = *t++) != '\0')
  ;
}
