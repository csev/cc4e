/** average3 - Computes the average of three numbers

*  Written by: C. Severance - Tue Dec  7 10:47:44 EST 1993

*/

main() {

  float a,b,c,tot,ave;

/* Prompt the user for the three variables */

  printf("enter the first number - ");
  scanf("%f",&a);
  printf("enter the second number -");
  scanf("%f",&b);
  printf("enter the third number -");
  scanf("%f",&c);

/* Print the numbers out */

  printf("the numbers are - %f %f %f\n",a,b,c);

/* Calculate the total and average */

  tot = a + b + c;
  ave = tot / 3.0;

/* Print the values out and end the program */

  printf("total -  %f\n",tot);
  printf("average -  %f\n",ave);
}
