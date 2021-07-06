/* Demonstrattion of the effect of call by reference */

main()

{
  int a,b,c,d;

  a = 1;
  b = 2;
  c = 3;
  d = 0;

  printf("main-1 a=%d b=%d c=%d d=%d\n",a,b,c,d);

  d = func(a,b,c);

  printf("main-3 a=%d b=%d c=%d d=%d\n",a,b,c,d);
}

/* Type and number of parameters in the function declaration must match
   type and number of parameters in the function call */

int func(x,y,z)

  int x;
  int y;
  int z;
{

  printf("func-1 x=%d y=%d z=%d\n",z,y,z);

  z = x + y;
  x = 4;

  printf("func-2 x=%d y=%d z=%d\n",z,y,z);

  return 27;
}
