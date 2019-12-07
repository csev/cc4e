
/* Program factable - compute the factorial table

* Written by - Charles Severance - Tue Dec  7 17:28:52 EST 1993

*/

main() {

  int i,n,fac;

/* Print heading */

  printf("      NUMBER      FACTORIAL\n") ;
  printf("      ------      ---------\n");

/*  Loop through the numbers 1-10 and print out the factorials */

  for( n=1;n<=10;n++) {
    fac = 1;
    for( i=2; i<=n; i++ ) {
      fac = fac * i;
    }
    printf("      %6d     %10d\n",n,fac);
  }

}
