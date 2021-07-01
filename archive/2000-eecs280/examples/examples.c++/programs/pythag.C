
/* pythag - Calaculates the hypotenuse given two sides of a triangle */

/*  Written by: C. Severance - Tue Dec  7 22:31:01 EST 1993 */

#include<math.h>
#include <iostream.h>

main() {

  float a,b,hyp;
  double tmp,sqrt(double);

/* Prompt the user two sides of the triangle */

  cout << "enter the first side of the triangle -";
  cin >> a;
  cout << "enter the second side of the triangle -";
  cin >> b;

/* Calculate the hypotenuse */

  tmp = a * a + b * b;
  hyp = sqrt ( tmp ); 
  cout << "third side of the triangle is -  " << hyp << "\n";
}
