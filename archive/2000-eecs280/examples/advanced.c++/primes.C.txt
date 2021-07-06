
/* primes - Print out the primes from 1-15 */

/*  Written by: C. Severance Tue Dec  7 22:25:30 EST 1993 */

#include <iostream.h>

main() {

  int value,isprime,j,test;

/* Outside loop goes from 1 to 15 */

  for( value=1; value<=15; value++ ) {

/* The inside loop will see if there are any numbers other than 1 and */
/* the number itself can be evenly divided into the number.  If a some other  */
/* number evenly divides intothe number it is not prime. */

    isprime = 1;
    for( j=2; j<=value-1; j++ ) {
      test = value / j;
      if ( value == (test * j) ) {
        isprime = 0;
      }
    }

/* Now print out whether or not the number is prime */

    if ( isprime == 1 ) {
      cout << value << "  is a prime number\n";
    } else {
      cout << value << "  is a composite number\n";
    }
  }
}
