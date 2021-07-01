
#include <iostream.h>
#include <String.h>

main() {

  int i,icount;
  char ch;
  String str;
  String str1,str2;
  String starr[10];

  // Demonstrate input and output

  cout << "Enter a string with several blank separated words\n";
  readline(cin,str);
  cout << "readline(cin,str) returns:" << str << "\n";
  cout << "Enter another string with several blank separated words\n";
  cin >> str;
  cout << "cin >> str returns:" << str << "\n";
  readline(cin,str);  // Throw away the rest

  // Demonstrate assignments

  str1 = str;
  str2 = "A string constant";

  // Demonstrate comparisons

  cout <<  "Enter a string to be compared with the string bob\n";
  readline(cin,str);
  if ( str == "bob" ) cout << "You typed bob - so clever\n";
  if ( str < "bob" ) cout << "You typed something lower than bob\n";
  if ( str > "bob" ) cout << "You typed something higher than bob\n";

  // Demonstrate concatenation

  str1 = "Hi";
  str1 = str1 + ' ';    // Concatenate a character
  str1 = str1 + "bob";  // Concatenate a string constant
  str1 += ' ';          // Use the += operator
  str2 = "how's the weather";
  str1 = str1 + str2;   // Concatenate another string

  cout << "str1 = " << str1 << '\n' ;

  //  Look at this - Think of this as a "string expression"

  cout << "str1 = " + str1 + '\n';    

  // Lets try some substrings

  str = str1;             // All of the hi bob hows the weather
  str1 = str(3,5);        // Substrings can be assigned back into strings
  ch = str[3];            // You can extract a single character
 
  cout << str << "\n";
  cout << "01234567890123456789012345\n";

  cout << "str(3,5) = " << str(3,5) << '\n'; 
  cout << "str(20,10) = " << str(20,10) << '\n';
  cout << "Note:the substring understands the length and does not blow up\n";

  cout << "str.through(10) = " << str.through(10)  << '\n';
  cout << "str.from(10) = " << str.from(10) << '\n';
  cout << "str.after(10) = " << str.after(10) << '\n';

  // Delete some characters

  str1 = str; 
  cout << "Before str1.del(3,5) " << str1 << '\n';
  str1.del(3,5);
  cout << "After  str1.del(3,5) " << str1 << '\n';

  // Do a substitition

  str1 = str; 
  cout << "Before str1.gsub(\"bob\",\"steve\") " << str1 << '\n';
  str1.gsub("bob","steve");
  cout << "After  str1.gsub(\"bob\",\"steve\") " << str1 << '\n';
  
  // Do some parsing

  cout << "Enter a line with several words\n";
  readline(cin,str);
  
  icount = split(str,starr,10,' ');    // Split

  cout << "Split into " << icount << " elements\n";
  for(i=0;i<icount;i++) {
    cout << "word [" << i << "] = " << starr[i] << "\n";
  }
  
  // Play with some other functions

  str1 = str;
  cout << "reverse(str1) = " << reverse(str1) << '\n';
  str1 = str;
  cout << "upcase(str1) = " << upcase(str1) << '\n';
  str1 = str;
  cout << "downcase(str1) = " << downcase(str1) << '\n';
  str1 = str;
  cout << "capitalize(str1) = " << capitalize(str1) << '\n';

  // Watch this....

  str1 = str;
  cout << "capitalize(str1(0,3)) + str1(3,str1.length()-3) = " << 
           capitalize(str1(0,3)) + str1(3,str1.length()-3) << '\n';

  // Lets do it another way

  str1 = str;
  str1(0,3) = capitalize(str1(0,3));
  cout << str1 << '\n';
}
