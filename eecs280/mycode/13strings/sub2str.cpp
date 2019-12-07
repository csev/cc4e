#include <iostream.h>

void sub2str(char outstr[],char instr[],int a,int b)
// Precondition: instr contains a properly terminated string
//  a and b are the beginning and ending positions within instr
// Postcondition: outstr contains a properly terminated string
//    which are characters from position a to b inclusive
//    if a is > length of instr, then outstr is an empty string
//    if b is > length of instr, then outstr contains characters
//         from a through the end of instr
// Note: Has absolutely no idea regarding the actual maximum length
//    of either instr or outstr - may fail when told to do stupid
//    things - caveat emptor
{
  int i,j;

  for(j=0; instr[j] && j < a; j++ ) ;  // Scan to a, checking for end
  i = 0; // Where to insert into outstr
  while ( instr[j] && j <= b ) outstr[i++] = instr[j++];
  outstr[i] = '\0';  // Make sure to terminate

} /*E* End of routine sub2str */

int main() {
  char a[100] = "Howdy Bob";
  char b[100];

  sub2str(b,a,6,8);
  cout << "B:" << b << endl;
}
