
/* A program to demonstrate some of the nifty UNIX capabilities in C */

#include <stdio.h>

main()

{
  FILE *pipefp;
  char tmp[100];

  printf("Opening Pipe...\n");

  pipefp = popen("ls -l","r");
  if ( pipefp == NULL ) {
    fprintf(stderr,"Unable to open pipe\n");
    exit();
  }

  while(fgets(tmp,100,pipefp) != NULL ) {
    printf("Line: %s",tmp);
  }  /* End while */

  pclose(pipefp);

}
