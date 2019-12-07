#include <iostream>
#include <string>
#include <cstring>
using namespace std;

main() {

  char ch;
  string str1 =     "I am a C++ string";
  string str2;
  char cstr1[100] = "I am a C string";
  char cstr2[100];

  // Syntactic equivalance - Read a character
  ch = str1[9];
  cout << "str1[9] = " << ch << endl;
  ch = cstr1[9];
  cout << "cstr1[9] = " << ch << endl;

  // Change a character - neither range checked
  str1[0] = 'i';
  cout << "str1 = " << str1 << endl;
  cstr1[0] = 'i';
  cout << "cstr1 = " << cstr1 << endl;

  // Polymorphism makes things seem the same
  cout << "Enter two words" << endl;
  cin >> str2;
  cin >> cstr2;
  cout << "str2 = " << str2;
  cout << " cstr2 = " << cstr2 << endl;

  // c_str() is a readonly accessor

  // strcpy(str2.c_str(),cstr1);   // Fails
  // Compiler: passing `const char *' as argument 1 of
  // `strcpy(char *, const char *)' discards qualifiers

  strcpy(cstr2,str1.c_str());  // Works!
  strcpy(cstr2,str1);  // Works!
  cout << "cstr2 = " << cstr2 << endl;

  str2 = cstr1;  // Seems too easy.. Thanks Polly.
  cout << "str2 = " << str2 << endl;

}
