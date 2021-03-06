
/* Program sortarr - Sort an array, computet the mean, median, max and mi */

/* Program can handle up to 100 values */

/* Written by - Charles Severance  - Tue Dec  7 22:46:36 EST 1993 */

#include <stdio.h>

main() {

  float values[100],mean,median,max,min,tmp,total;
  int i,j,count;

/* Read in the values counting how many we got */

  count = 0;
  while(count<100) {
    if ( scanf("%f",&tmp) == EOF ) break;
    values[count] = tmp;
    count = count + 1;
  }

  printf("read in  %d values\n",count);

  if ( count == 0 ) {
    printf("program has read no data... %d\n");
    exit();
  }

/*  Sort the array */

  for( i=0; i<count-1; i++ ) {
    for( j=i+1; j<count; j++ ) {
      if ( values[i]>values[j] ) {
        tmp = values[i];
        values[i] = values[j];
        values[j] = tmp;
      }
    }
  }

/* Print out the sorted values */

  for( i=0; i<count; i++ ) {
    printf("%f\n",values[i]);
  }

/* Find the maximum and minimum and total */

  max = values[0];
  min = values[0];
  total = 0.0;
  for( i=0; i<count; i++ ) {
    if ( values[i] > max ) max = values[i];
    if ( values[i] < min ) min = values[i];
    total = total + values[i];
  }
  mean = total/count;

/* Find the median.  The median is different whether the total number */
/* is even or odd.  We use the MOD function which gives us the remainder */
/* of an integer division to determine if the value is even or odd. */

  if ( (count % 2) == 1 ) {
    median = values[ count/2 + 1 ];
  } else {
    median = (values[count/2] + values[count/2+1]) / 2;
  }

/* Print everything out */

  printf("\n");
  printf("mean =  %f\n",mean);
  printf("median =  %f\n",median);
  printf("minimum =  %f\n",min);
  printf("maximum =  %f\n",max);

}
