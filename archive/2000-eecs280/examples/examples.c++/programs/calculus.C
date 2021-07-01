
/* calculus - Estimate the area under the curve Y=X**2 from 0-1

*  Written by: C. Severance - Tue Dec  7 17:15:12 EST 1993

*/

#include <math.h>
#include <iostream.h>

main() {

  float x,area,rect,error;
  double tmp;
  double fabs();

  area = 0.0;
  for( x=0.0; x<=1.00; x=x+0.1) {
    rect = 0.1 * (x * x);
    area = area + rect;
  }

/* Print out the approximate area and actual area and the error */

  cout << "approximate area = " << area << "\n";
  cout << "actual area = " << 1.0/3.0 << "\n";
  tmp =  (1.0/3.0) - area;
  error = fabs ( tmp ) ;
  cout << "error = " << error << "\n";
}
