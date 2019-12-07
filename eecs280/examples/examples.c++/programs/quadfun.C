
/* Program quadfun - calculate the quadratic formula roots using a function */

/* Written by - C. Severance  - Tue Dec  7 22:36:33 EST 1993 */

/* Declare that the first two parameters are pass by reference */

#include <stdio.h>
#include <iostream.h>
#include <math.h>

void quadfun(float &, float &, float, float, float);

main() {

  float a,b,c,root1,root2;
  float q,r,s,roota,rootb;

  cout << "enter a,b,c -";
  cin >> a;
  cin >> b;
  cin >> c;

  quadfun(root1,root2,a,b,c);

  cout << "root1 = " << root1 << "\n";
  cout << "root2 = " << root2 << "\n";

/* Lets do it again  - use stdio this time */

  printf("enter q,r,s -");
  scanf("%f %f %f",&q,&r,&s);

  quadfun(roota,rootb,q,r,s);

  printf("roota =  %f\n",roota);
  printf("rootb =  %f\n",rootb);

}

/* Function quadfun */

void quadfun(float &r1,float &r2,float a,float b,float c)

{
  double td;
  double sqrt();

  td = b*b - 4 * a * c;
  td = sqrt ( td ) ;

  r1 = ( -1.0*b + td ) /  ( 2 * a );
  r2 = ( -1.0*b - td ) /  ( 2 * a );

  return;
}
