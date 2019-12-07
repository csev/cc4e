#include <iostream>
#include <string>
using namespace std;

main() {

  char ch;
  string str;
  string str1,str2;
  string starr[10];

  // Demonstrate input and output

  cout << "Enter several words\n";
  getline(cin,str);
  cout << "getline(cin,str) returns:" << str << "\n";
  cout << "Enter more words\n";
  cin >> str;
  cout << "cin >> str returns:" << str << "\n";
  getline(cin,str);  // Throw away the rest

  // Demonstrate assignments
  str1 = str;
  str2 = "A string constant";

  // Demonstrate comparisons
  cout <<  "Enter a string to be compared\n";
  getline(cin,str);
  if ( str == "bob" ) cout << "Exactly bob\n";
  if ( str < "bob" ) cout << "Less than bob\n";
  if ( str > "bob" ) cout << "Greater than bob\n";

  // Demonstrate concatenation
  str1 = "Hi";
  str1 = str1 + ' ';    // Concatenate a character
  str1 = str1 + "bob";  // Concatenate a string constant
  str1 += ' ';          // Use the += operator
  str2 = "how's the weather";
  str1 = str1 + str2;   // Concatenate another string

  cout << "str1 = " << str1 << '\n' ;

  // How long?
  cout << "str1.length() = " << str1.length() << endl ;

  //  A "string expression"
  cout << "str1 = " + str1 + '\n';    

  // Lets try some substrings
  str = str1;             // A wholestring
  str1 = str.substr(3,5);        
  ch = str[3];   // A single character
  ch = str.at(3);   // With bounds checking

  cout << "str[3] = " << str[3] << '\n';
  cout << "str.at(3) = " << str.at(3) << '\n';  // Safe
 
  cout << str << "\n";
  cout << "01234567890123456789012345\n";

  cout << "str.substr(3,5) = " << str.substr(3,5) << '\n'; 
  cout << "str.substr(20,10) = " << str.substr(20,10) << '\n';
  cout << "Note:the substr understands the length\n";

  // Delete some characters

  str1 = str; 
  cout << "Before str1.erase(3,5) " << str1 << '\n';
  str1.erase(3,5);
  cout << "After  str1.erase(3,5) " << str1 << '\n';

}
