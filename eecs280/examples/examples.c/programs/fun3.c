/*  Call by location */

main() {

  int i,j,k;

  i = 1;
  j = 2;
  k = 3;

  printf("In main-1 i=%d j=%d k=%d\n",i,j,k);

  func(&i,j,k);

  printf("In main-2 i=%d j=%d k=%d\n",i,j,k);

}

func(a,b,c)

  int *a;
  int b;
  int c;

{

  int x,y;

  printf("In func-1 b=%d c=%d\n",b,c);

  x = *a;     /* Right */
  y = a;      /* Wrong */

  printf("In func-2 x=%d y=%d\n",x,y);

  x = b + 5 + *a + 4;

  printf("In func-3 x=%d\n",x);

  *a = 12 + b * 1;
  c = 9;

  printf("In func-4 *a=%d a=%d b=%d c=%d\n",*a,a,b,c);

}
  

/* Output 

In main-1 i=1 j=2 k=3
In func-1 b=2 c=3
In func-2 x=1 y=67108068
In func-3 x=12
In func-4 *a=14 a=67108068 b=2 c=9
In main-2 i=14 j=2 k=3

*/
