
#include <math.h>
#include <iostream.h>

#include "time.C"

main() {

  int i,j,numser,signval;
  double nfac;
  double x,powval,result;
  double sin();
  double start,end,et;

  cout << "Taylor series calculator...\n";

  cout << "Please enter a number to take the SIN of\n";
  cin >> x;

  while(1) {
  
    if ( cin.eof() ) break;
    cout << "Please enter the number of Taylor series terms you want\n";
    cin >> numser ;
    if ( cin.eof() ) break;
  
    if ( numser < 1 || numser > 100 ) {
      cout << "Please enter a number between 1 and 100\n";
      continue;
    }

    cout << "Computing Taylor series 20000 times...\n";

    start = msu_cpu();

    for(j=1;j<20000;j++ ) { /* To make the time noticable */
      nfac = 1;
      powval = x;
      signval = 1; 
      result = 0;
  
      for(i=1; i<=numser*2; i++) {
  
        result = result + signval * ( powval / nfac ) ;
  
        // cout << powval << " " << signval << " " << nfac << "\n";
        // cout << result << "\n";
        powval = powval * x * x;
        signval = signval * -1;
        nfac = nfac * (2 * i) * (2 * i + 1);
      }
    }
    end = msu_cpu();
    et = end - start;

    cout << "SIN(" << x << ") approximated to " << numser << " terms is ";
    cout << result << " in " << et << " seconds\n";
  }

}


