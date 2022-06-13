sort(v, n, comp, exch) /* sort strings v[0]...v[n-1] */
char *v[]; /* into increasing order */
int n;
int (*comp)(), (*exch)();
{
  int gap, i, j;

  for (gap = n/2; gap > 0; gap /= 2)
    for (i = gap; i < n; i++)
      for (j = i-gap; j >= 0; j -= gap) {
        if ((*comp)(v[j], v[j+gap]) <= 0)
          break;
        (*exch)(&v[j], &v[j+gap]);
      }
}
