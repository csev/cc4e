/* 
* aveetc - Program which demonstrates the read loop for processing
* an unknown number of input lines
*
* This program reads any number of values from input until end of file
* is reached.  The count, total, and average of the values is printed.
*
* Written by: Charles Severance Tue Dec  7 10:39:23 EST 1993
*/

#include <stdio.h>

main() {

  int count;
  float value,sum,average,total;

  sum = 0.0;
  count = 0.0;
  total = 0.0;

/*
* Top of the read loop.  Read the values.  If end of file is encountered
* we go to line 20.  In the read statement the first asterisk is where
* to read from and the second is the FORMAT of the input.
*
* NOTE that on UNIX systems End of file can be entered
* by pressing CTRL-D when the program is reading from the terminal.
*/

  while(1) {
    if ( scanf("%f",&value) == EOF ) break;
    total = total + value;
    count = count + 1;

    printf("Value = %f\n", value);
    printf("Running total = %f\n",total);
    printf("Count = %d\n", count);
  } /* End while */

/* Loop exit when end of file is reached - calculate average and print out */

  printf("We got End of FILE!!\n");
  average = total/count;
  printf("Average = %f\n",average);

} /* End of main */
