#include <stdio.h>

int main () {
   char str1[1000];

   sscanf("Chuck", "%s", str1);
   printf("Your name is %s\n", str1);

}
