shell(v, n) /* sort v[0]...v[n-1] into increasing order */
int v[], n;
{
  int gap, i, j, temp;

  for (gap = n/2; gap > 0; gap /= 2)
    for (i = gap; i < n; i++)
      for (j=i-gap; j>=0 && v[j]>v[j+gap]; j -= gap){
        temp = v[j];
        v[j] = v[j+gap];
        v[j+gap] = temp;
      }
}
