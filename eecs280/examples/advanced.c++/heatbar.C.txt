
/* Program heatbar - Calculate heat flows in a 100CM bar

* Bar initially starts out at 30 degrees C

* At 1 CM there is a 100 degree C heat source
* At 63 CM there is a 0 degree heat source
* At 100 CM there is a 60 degree source

* The program will print out the temperature at 10 50 and 80 CM
* After 1, 10, and 100 time steps

* Written by - Charles Severance - Tue Dec  7 17:51:34 EST 1993
*/

#include <iostream.h>

main() {

  float bar[100];
  int time,pos,i;

/* Initialize the bar */

  for( i=0;i<100;i++ ) {
   bar[i] = 30.0;
  }
  bar[0] = 100.0;
  bar[62] = 0.0;
  bar[99] = 60.0;

/*  Loop through the time steps.  For each time step the new temperature */
/*  is calculated at each point in the bar.  Make sure we don't recalc */
/*  the fixed temperature positions */

  for(time=1;time<=100;time++) {

    for( pos=1; pos<62; pos++ ) {
      bar[pos] = ( bar[pos-1] + bar[pos] + bar[pos+1] ) / 3.0;
    }
    for( pos=63; pos<99;pos++ ) {
      bar[pos] = ( bar[pos-1] + bar[pos] + bar[pos+1] ) / 3.0;
    }

/* The program will print out the temperature at 10 50 and 80 CM */
/* After 1, 10, and 100 time steps */

    if ( time == 1 || time == 10 || time == 100 ) {
      cout << "time step  " << time << "\n";
      cout << "at bar[10] =  " << bar[10] << "\n";
      cout << "at bar[50] =  " << bar[50] << "\n";
      cout << "at bar[80] =  " << bar[80] << "\n";
    }
  }
}
