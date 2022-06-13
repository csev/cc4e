numcmp(s1, s2) /* compare s1 and s2 numerically */
char *s1, *s2;
{
  double atof(), v1, v2;

  v1 = atof(s1);
  v2 = atof(s2);
  if (v1 < v2)
    return(-1);
  else if (v1 > v2)
    return(1);
  else
    return(0);
}
