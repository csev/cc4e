strcpy(s, t) /* copy t to s; pointer version 1 */
char *s, *t;
{
  while ((*s = *t) != '\0') {
    s++;
    t++;
  }
}
