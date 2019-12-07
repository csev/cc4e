
#include <stdio.h>

main() {

  char tmp[100];
  int i,j;

  int n;

  while (1) {

    printf("Calling gets ");

    if ( gets(tmp) == NULL ) break;

    printf("tmp=%s\n",tmp);

    if ( tmp[0] == '*' ) {
      printf("Got a comment!\n");
      continue;
    }

    n = sscanf(tmp,"%d %d",&i,&j);

    printf("n=%d i=%d j=%d\n",n,i,j);

  }

}


/*
$ a.out
Calling gets 1 2
tmp=1 2
n=2 i=1 j=2
Calling gets 3 4
tmp=3 4
n=2 i=3 j=4
Calling gets       1            9
tmp=      1            9
n=2 i=1 j=9
Calling gets 175
tmp=175
n=1 i=175 j=9
Calling gets *
tmp=*
Got a comment!
Calling gets 1 2 3 4 5 6 7 8 9 
tmp=1 2 3 4 5 6 7 8 9 
n=2 i=1 j=2
Calling gets [CTRL-D]

$

*/
