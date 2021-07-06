/* A program which sorts grade information */

main () {

  int count;
  int i,j,k;
  float gt0,gt1,gt2;
  int tmp;
  int pid[100];
  float grades[100][3];

  count = 0;
  while ( count < 100 ) {
   if ( scanf("%d %f %f %f",&i,&gt0,&gt1,&gt2) != 4 ) break;
   pid[count] = i;
   grades[count][0] = gt0;
   grades[count][1] = gt1;
   grades[count][2] = gt2;
   count++;
  }  

  for(i=0;i<count-1;i++) { 
    for (j=i+1;j<count;j++) {
      if ( pid[i] > pid[j] ) {
        tmp = pid[i];
        gt0 = grades[i][0];
        gt1 = grades[i][1];
        gt2 = grades[i][2];
        pid[i] = pid[j];
        for(k=0;k<3;k++) grades[i][k] = grades[j][k];
        pid[j] = tmp;
        grades[j][0] = gt0;
        grades[j][1] = gt1;
        grades[j][2] = gt2;
      }
    }
  }

  for(i=0;i<count;i++ ) {
    printf("%d %6.2f %6.2f %6.2f\n",
         pid[i],grades[i][0],grades[i][1],grades[i][2]);
  }
}

/* Execution

$ cc struct0.c
$ cat gradepretty.dat
102434 0.80 0.90 0.95
928394 0.60 0.99 0.70
374374 1.00 0.50 1.00
222222 0.80 0.50 0.95
172387 0.92 0.92 1.00
$ a.out < gr
gradepretty.c    gradepretty.dat  grades.c         
$ a.out < gradepretty.dat
102434   0.80   0.90   0.95
172387   0.92   0.92   1.00
222222   0.80   0.50   0.95
374374   1.00   0.50   1.00
928394   0.60   0.99   0.70
$ 

*/
