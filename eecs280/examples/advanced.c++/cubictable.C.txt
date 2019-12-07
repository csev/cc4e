
/* Program cubictable - print out the values for a cubic function

* Written by - Charles Severance - Tue Dec  7 17:23:57 EST 1993
*/

#include <iostream.h>

main() {

  float x,fun;

  for( x=-3.0; x<=3.0; x=x+0.4 ) {
    fun = (x * x * x) + 2 * (x * x) - x - 2.0;
    cout << " " << x << " " << fun << "\n";
  }
}
