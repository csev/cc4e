
/* Program quad - calculate the quadratic formula roots */

/* Written by - C. Severance Tue Dec  7 22:34:11 EST 1993 */

#include <math.h>
#include <iostream.h>

main() {

  float a,b,c,det,root1,root2;
  double tmp,sqrt(double);

  cout << "enter a b c -";
  cin >> a >> b >> c;

  tmp = b*b - 4 * a * c;
  det = sqrt( tmp );
  root1 = ( -1.0*b + det ) /  ( 2 * a );
  root2 = ( -1.0*b - det ) /  ( 2 * a );

  cout << "root1 =  " << root1 << "\n";
  cout << "root2 =  " << root2 << "\n";

}
