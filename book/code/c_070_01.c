#define MAXLINE 100

main() /* rudimentary desk calculator */
{
  double sum, atof();
  char line[MAXLINE];

  sum = 0;
  while (getline(line, MAXLINE) > 0)
    printf("\t%.2f\n", sum += atof (line));
}
