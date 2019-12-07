
#include <iostream.h>
#include "time.C"

/* Print out a fibonacci sequence with timing information */

main() {

  int i,result;
  int fib(int);
  double start,end,ellapsed;
  double msu_cpu();

  for(i=0;i<35;i++) {

    start = msu_cpu();
    result = fib(i);
    end = msu_cpu();
    ellapsed = end - start;

    cout << "FIB(" << i << ") = " << result << "   ";
    cout << ellapsed << " seconds\n";
  }

}

fib(int parm)

{
  if ( parm < 2 ) return(1);
  return(fib(parm-1)+fib(parm-2));
}
