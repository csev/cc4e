#include <iostream.h>

int main() {
  char ch;
  while ( ! cin.eof() ) {
    cout << "Enter " ; 

    cin >> ch;
    cout << "Ival:" << int(ch) << ":" << ch << endl;
  }
}
