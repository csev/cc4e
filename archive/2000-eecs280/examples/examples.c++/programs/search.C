

#include <iostream.h>
#include "time.C"

/* Do a search using binary search and a sequeential search */

#define MAX 1000000

int space[MAX];

main() {

  int i,j;
  int newpos,where;
  int right,left;
  int num;
  int search;
  double start, end, ellapsed;

  cout << "Creating array of "<<MAX<<" even numbers (sorted)...\n";

  for(i=0;i<MAX;i++) {
    space[i] = i * 2;
  }

  while(1) {

    cout << "Please enter the number of elements to search\n";
    cin >> num;

    if ( cin.eof() ) break;
  
    if ( num < 1 || num > MAX ) {
      cout << "Please enter a number between 1 and " << MAX << "\n";
      continue;
    }

/* Choose a random number */

   search = (num * 0.80) + random() % (int) (num * 0.10);

/* do a sequential search */

   cout << "Searching for " << search << " sequentially...\n";

    start = msu_cpu();

    for(j=1;j<20;j++) {
      for(i=0;i<num;i++) {
        if ( space[i] == search ) break;
      }
    }

    end = msu_cpu();
    ellapsed = end - start;

    if (i >= num ) {
      cout << search << " not found in " << ellapsed << " seconds\n";
    } else {
      cout << "Found " << search << " in " << ellapsed << " seconds\n";
    }

/* do a binary search */

    cout << "Searching for " << search << " using binary search...\n";

    start = msu_cpu();

    for(j=1;j<500;j++) {

      left = 0;
      right = num-1;

      while(1) {
        newpos = left + (right - left) / 2 ;
        if ( newpos == where ) break;
        where = newpos;
        // cout <<left<<" "<< where <<" "<<right<<" = "<< space[where]<< "\n";
        if ( space[where] == search ) break;
        if ( search > space[where] ) left = where;
        if ( search < space[where] ) right = where;
      }
    }

    end = msu_cpu();
    ellapsed = end - start;

    if ( space[where] == search) {
      cout << "Found " << search << " in " << ellapsed << " seconds\n";
    } else {
      cout << search << " not found in " << ellapsed << " seconds\n";
    }
  }

}
