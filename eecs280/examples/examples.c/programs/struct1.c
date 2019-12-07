/* A program which sorts using structures */

struct grtype {
  int pid;
  float grades[3];
} ;

main () {

  int count;
  int i,j,k;
  float gt0,gt1,gt2;
  struct grtype info[100];
  struct grtype tmp;

  /* Read */
  count = 0;
  while ( count < 100 ) {
   if ( scanf("%d %f %f %f",&i,&gt0,&gt1,&gt2) != 4 ) break;
   tmp.pid = i;
   tmp.grades[0] = gt0;
   tmp.grades[1] = gt1;
   tmp.grades[2] = gt2;
   info[count] = tmp;
   count++;
  }  

  /* Sort */
  for(i=0;i<count-1;i++) { 
    for (j=i+1;j<count;j++) {
      if ( info[i].pid > info[j].pid ) {
        tmp = info[i];
        info[i] = info[j];
        info[j] = tmp;
      }
    }
  }

  /* Print */
  for(i=0;i<count;i++ ) {
    printf("%d %6.2f %6.2f %6.2f\n",
       info[i].pid,info[i].grades[0],info[i].grades[1],info[i].grades[2]);
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

