
/* squares - Print a table of squares from 1 to 10 */

/*  Written by: C. Severance  - Tue Dec  7 22:58:26 EST 1993 */

main() {

  int i;
  float x,xsq;

/* Generate the table using a loop */

  printf("the first table\n");
  for( i=1; i<=10; i++ ) {
    x = i;
    xsq = x * x;
    printf("%5d %f\n",i,xsq);
  }

/* Print out the table a different way - Use a real number for the index */

  printf("the second table\n");
  for( x=1.0; x<=10.0; x = x + 1.0 ) {
    xsq = x * x;
    printf("%f %f\n",x,xsq);
  }

}
