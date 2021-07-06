/** average3 - Computes the average of three numbers

*  Written by: C. Severance - Tue Dec  7 10:47:44 EST 1993

*/

#include <iostream.h>

main() {

  float a,b,c,tot,ave;

/* Prompt the user for the three variables */

  cout << "enter the first number - ";
  cin >> a;
  cout << "enter the second number -";
  cin >> b;
  cout << "enter the third number -";
  cin >> c;

/* Print the numbers out */

  cout << "the numbers are - " << a << " " << b << " " << c << " " << "\n";

/* Calculate the total and average */

  tot = a + b + c;
  ave = tot / 3.0;

/* Print the values out and end the program */

  cout << "total -  " << tot << "\n";
  cout << "average -  " << ave << "\n";
}
