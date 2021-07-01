
/* grades - Calculate student grades based on partial scores

* The final grade is 30programs, 50tests and 20homework

* Grades are assigned based on the following scale:

*    >0.90 4.0
*    >0.80 3.0
*    >0.70 2.0
*    <0.60 0.0

*  Written by: C. Severance - Tue Dec  7 17:33:38 EST 1993

*/

#include <iostream.h>

main() {

  float pper,tper,hper,totam;

/* Prompt the user for the three percentages */

  cout << "enter the program percentage - ";
  cin >> pper;
  cout << "enter the test percentage - ";
  cin >> tper;
  cout << "enter the homework percentage - ";
  cin >> hper;

/* Calculate the total percentage */

  totam = pper * 0.30 + tper * 0.50 + hper * 0.20;
  cout << "total percentage is  " <<  totam << "\n";

/* Determine the final grade */

  if ( totam >= 0.90 ) {
    cout << "grade is 4.0" << "\n";
  } else if ( totam >= 0.80 ) {
    cout << "grade is 3.0" << "\n";
  } else if ( totam >= 0.70 ) {
    cout << "grade is 2.0" << "\n";
  } else {
    cout << "grade is 0.0" << "\n";
  }
}
