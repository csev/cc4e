
/* payroll - calculate pay given time and a half for overtime

*  Written by: C. Severance - Tue Dec  7 22:18:41 EST 1993

*/

#include <iostream.h>

main() {

  float rate,hours,pay;

/* Prompt the user for hours and the rate */

  cout << "enter the hours worked -";
  cin >> hours;
  cout << "enter the pay per hour -";
  cin >> rate;

/* Calculate the pay compensating for overtime */

  if ( hours > 40.0 ) {
    pay = rate * 40.0 + ( rate * 1.5 * (hours - 40.0));
  } else {
    pay = rate * hours;
  }

/* Print out the pay */

  cout << "pay is -  " << pay << "\n";
}
