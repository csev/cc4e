
/* Program quad - calculate the quadratic formula roots */

/* Written by - C. Severance Tue Dec  7 22:34:11 EST 1993 */

#include <math.h>

main() {

  float a,b,c,det,root1,root2;
  double tmp;

  printf("enter a,b,c: ");
  scanf("%f %f %f",&a,&b,&c);

  tmp = b*b - 4 * a * c;
  det = sqrt( tmp );
  root1 = ( -1.0*b + det ) /  ( 2 * a );
  root2 = ( -1.0*b - det ) /  ( 2 * a );

  printf("root1 =  %f\n",root1);
  printf("root2 =  %f\n",root2);

}
