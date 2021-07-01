
/* This program demonstrates the method of
   passing command line arguments to a C Program */

#include <stdio.h>

main(argc, argv)

  int argc;
  char* argv[];

{
  int i;

  printf("Number of command line arguments: %d\n",argc);

  for(i=0;i<argc;i++){
    printf("Argument %d is %s\n",i,argv[i]);
  }

}

/* Example Execution

$ a.out 1 2 3 4 5
Number of command line arguments: 6
Argument 0 is a.out
Argument 1 is 1
Argument 2 is 2
Argument 3 is 3
Argument 4 is 4
Argument 5 is 5
$ a.out *.dat
Number of command line arguments: 3
Argument 0 is a.out
Argument 1 is gradepretty.dat
Argument 2 is output.dat
$

*/
