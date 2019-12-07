
/* A program to demonstrate some of the nifty UNIX capabilities in C */

#include <stdio.h>

main()

{
  char tmp[100];

  printf("About to call the system command, press enter");
  gets(tmp);

  system("ls -l");

  printf("Just came back from the system command\n");
  
}
