
#define TEST_SUITE
#ifdef TEST_SUITE
#include <iostream.h>
#endif

#include <ctype.h>
#include <string.h>

/** input_line - An object to handle/parse input lines

  Written by: Charles Severance - Thu Dec 23 17:02:01 EST 1993

*/

class input_word {
  public:
    char word[80];                 // The word
    int maxlen;
  };

int operator == (const input_word& iw, const char* str)
{
  int i;
  // cout << iw.word << " == " << str << ":\n";
  for(i=0;iw.word[i] && str[i]; i++ ) if ( iw.word[i] != str[i] ) break;
  return(iw.word[i] == str[i]);
}


int operator == (const char* str ,const input_word& iw)
{
  return( iw == str ) ;
}

class input_line {
  public:
    char *line;                  // The line itself
    class input_word* words;     // The parsed words
    input_line(int,int);         // Constructor
    ~input_line();               // Destructor

    int maxwords;
    int numwords;

  };

input_line::input_line(int linelen=200, int nwords=20)   // Constructor
{
  line = new char[linelen];
  maxwords = nwords;
  words = new input_word[nwords];
}
  
input_line::~input_line(int s)
{
  delete[] words;
}

istream& operator>>(istream& is, input_line& il) 
{
  int i,iword,ichar;
  char c;
 
  i = 0;
  iword = 0;
  ichar = 0;
  while( is.get(c) ) {

    if ( c == '\n' ) break;

    il.line[i++] = c;

    if ( isspace(c) ){
      if ( ichar > 0 ) {
        ichar = 0;
        iword++;
      }
    } else { // Non-blank character
      if ( ichar >= 79 ) { // Terminate
        ichar = 0;
        iword++;
      }
      il.words[iword].word[ichar] = c;
      ichar++;
      il.words[iword].word[ichar] = '\0';   // Terminate the word
    }

  }  /* While */

  if ( ichar > 0 ) iword++;
  il.line[i] = '\0';
  il.numwords = iword;
  // cout << iword << " words\n";
}


ostream& operator<<(ostream& os, input_line& il) 
{
  int i;
  char c;
 
  for(i=0;il.line[i];i++) os.put(il.line[i]);
   
  os.put('\n');
}

#ifdef TEST_SUITE

/* Main testing routine */

main () {

  class input_line il(20);
  int i;
 
  cout << "Enter a line:\n";
  cin >> il;
  cout << "The line:\n";
  cout << il;
  cout << il.numwords << " words read in\n";
  for(i=0;i<il.numwords;i++) {
     cout << "word[" << i << "] =  " << il.words[i].word << '\n';
  }
 
  if ( il.words[0] == "bob" ) { cout<< "Hey BOB!\n"; } else { cout << "Nope\n";}


}

#endif
