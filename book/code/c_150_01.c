#include <stdio.h>

main() /* rudimentary desk calculator */
{
  double sum, v;

  sum = 0;
  while (scanf("%lf", &v) != EOF)
    printf("\t%.2f\n", sum += v);
}
