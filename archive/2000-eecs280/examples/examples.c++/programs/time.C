
#undef SOLARIS

#ifdef SOLARIS
#include <sys/times.h>
#include <limits.h>
#else
#include <sys/time.h>
#include <sys/resource.h>
#endif

#include <iostream.h>

#define RUSAGE_CHILDREN  -1        /* terminated child processes */

#define USEC                       /* Define if the time returns usec */
                                   /* undefine if it returns nsec */
/** msu_cpu - give ellapsed CPU time so far 

  Written by: Charles Severance - Wed Dec 22 11:58:17 1993

*/

double msu_cpu()

{
  double retval;


#ifdef SOLARIS
  clock_t clock(void);

  clock_t cval;
  
  cval = clock();

  retval =  CLOCKS_PER_SEC;
  retval = cval / retval;
  // cout << retval << "\n";
#else
  struct rusage ruval;

  getrusage(RUSAGE_SELF,&ruval);
  retval = ruval.ru_utime.tv_sec + (ruval.ru_utime.tv_usec) / 1000000.0 + 
           ruval.ru_stime.tv_sec + (ruval.ru_stime.tv_usec) / 1000000.0;
  // cout << ruval.ru_utime.tv_sec << " " << ruval.ru_utime.tv_usec << "\n";
  // cout << ruval.ru_stime.tv_sec << " " << ruval.ru_stime.tv_usec << "\n";
  // cout << retval << "\n";
#endif

  return(retval);

}


/* msu_wall - MSU C wall clock time

  Written by: Charles Severance Fri Mar  5 10:43:53 EST 1993

  Returns a ellapsed wall clock time correct to at least a millisecond.
  On the first call it returns zero and on all remaining calls, it returns
  ellapsed time from the first call.

*/

double msu_wall()

{
  static long zsec = 0;
  static long zusec = 0;

  double esec;

  struct timeval tp;
  struct timezone tzp;

  gettimeofday(&tp, &tzp);

  if ( zsec == 0 ) zsec = tp.tv_sec;
  if ( zusec == 0 ) zusec = tp.tv_usec;

  esec = (tp.tv_sec - zsec) + (tp.tv_usec - zusec ) * 0.000001 ;

  return(esec);

}

#ifdef TEST_SUITE

/* Main testing routine */

main () {

 int i;
 double msu_cpu();
 double msu_wall();
 double d,e;

 cout << "CPU  " << msu_cpu() << "\n";
 cout << "Wall " << msu_wall() << "\n";

 sleep(5);

 for(i=0;i<10000;i++ ) {
   d = msu_cpu();
   e = msu_wall();
  }

 cout << "CPU  " << msu_cpu() << "\n";
 cout << "Wall " << msu_wall() << "\n";

}

#endif
