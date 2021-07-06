#include <iostream.h>
#include <iomanip.h>
#include <stdlib.h>
#include <string>

void sub2str(char outstr[],char instr[],int a,int b);


int main() {

  char stra[10];
  char strb[100] = "Hello cruel world\n";
  char strc[] = "Hello 345 bob";
  char strd[] = {'T', 'e', 's', 't', '\0'};
  char stre[] = {66, 111, 98, 0};
  int i,j;
  double d;

  cout.precision(2);

  // Fails: incompatible types in assignment
  // stra = "Yo";

  strcpy(stra,"123");

  cout << "stra = " << stra << endl;
  cout << "strb = " << strb << endl;
  cout << "strc = " << strc << endl;
  cout << "strd = " << strd << endl;
  cout << "stre = " << stre << endl << endl;
  
  i = atoi(stra);
  cout << "atoi = " << i << endl;
  d = atof(stra);
  cout << "atof = " << d << endl;

  cout << "stre[2] = " << stre[2] << endl;
 
  strncpy(stra,&strc[6],3);
  
  cout << "After strncpy stra = " << stra << endl;
 
  j = 0;
  for ( i=6; i<=10;i++ ) {
    stra[j] = strb[i];
    j++;
  }
  stra[j] = '\0';
  cout << "After for loop stra = " << stra << endl;

  sub2str(stra,strb,6,10);  //  Dr. Chuck's code
  cout << "After sub2str stra = " << stra << endl;

  cout << endl << "Enter a few words" << endl;
  cin >> stra;  // Dangerous because length unknown
  cout << "first stra = " << stra << endl;
  cin >> stra;  
  cout << "second stra = " << stra << endl;

  cin.ignore(1000,'\n');

  cout << "Enter a long word" << endl;
  cin >> setw(10) >> stra;  // Safe
  cout << "stra = " << stra << endl;

  cin.ignore(1000,'\n');

  cout << endl << "Enter a few words" << endl;
  cin.getline(stra,10);
  cout << "stra = " << stra << endl;
 
}

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

