
/* This program demonstrates the method of
   passing command line arguments to a C Program 
   combined with file I/O */

#include <stdio.h>

main(argc, argv)

  int argc;
  char* argv[];

{
  int count, rec;
  char tmp[100];
  FILE* infile;

  printf("Number of command line arguments: %d\n",argc);

  for(count=1;count<argc;count++){
    printf("----- File : %s\n",argv[count]);

    infile = fopen(argv[count],"r");
    if ( infile == NULL ) {
      printf("Unable to open %s\n",argv[count]);
      continue;
    }

    for(rec=0;rec<5;rec++) {
      if(fgets(tmp,100,infile) == NULL ) break;
      fputs(tmp,stdout);
    }

    fclose(infile);
  }  /* End for all arguments */
}

/* Example Execution
$ cc arg2.c
$ a.out xyz.c arg2.c
Number of command line arguments: 3
----- File : xyz.c
Unable to open xyz.c
----- File : arg2.c

#include <stdio.h>

main(argc, argv)

  int argc;

$ a.out *.dat
Number of command line arguments: 3
----- File : gradepretty.dat
102434 0.80 0.90 0.95
928394 0.60 0.99 0.70

 ... More Output ...

$ 

*/

