
/* pythag - Calaculates the hypotenuse given two sides of a triangle */

/*  Written by: C. Severance - Tue Dec  7 22:31:01 EST 1993 */
 
#include <math.h>

main() {

  float a,b,hyp;
  double tmp;

/* Prompt the user two sides of the triangle */

  printf("enter the first side of the triangle: ");
  scanf("%f",&a);
  printf("enter the second side of the triangle: ");
  scanf("%f",&b);

/* Calculate the hypotenuse */

  tmp = a * a + b * b;
  hyp = sqrt ( tmp ); 
  printf("third side of the triangle is:  %f\n",hyp);
}
