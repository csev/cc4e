
/* Demonstration of the use of file oriented I/O 

   This is a program which prompts the user for a file name.  Then the 
   file is read line by line.  If a line is less than 10 characters it is 
   copied to the output file.  If a line is longer than 10 characters,
   an error is put in the output file.

*/

#include <stdio.h>

main()

{

  char fname[20];
  int i;
  int copy, discard;
  char tmp[100];
  FILE* infile;
  FILE* outfile;

  printf("Enter the file name to process:");
  fscanf(stdin,"%s",fname);

  infile = fopen(fname,"r");
  if ( infile == NULL ) {
    fprintf(stderr,"Unable to open %s\n",fname);
    exit();
  }

  outfile = fopen("output.dat","w");
  if ( outfile == NULL ) {
    fprintf(stderr,"Unable to open output.dat\n");
    exit();
  }

  printf("Processing data...\n");
  copy = 0;
  discard = 0;

  while(fgets(tmp,100,infile) != NULL ) {
    i = strlen(tmp);
    if ( i > 10 ) {
      fprintf(outfile,"Line too long\n");
      discard++;
    } else {
      fputs(tmp,outfile);
      copy++;
    }
  }  /* End while */

  fprintf(stdout,"%d records copied, %d records discarded\n",copy,discard);

  fclose(infile);
  fclose(outfile);

}

/* Example Execution

$ cc fopen.c
$ a.out
Enter the file name to process:pythag.c
Processing data...
10 records copied, 13 records discarded
$ cat output.dat 

Line too long

Line too long

main() {

Line too long
Line too long

Line too long

Line too long
Line too long
Line too long
Line too long

Line too long

Line too long
Line too long
Line too long
}
$ 

*/
