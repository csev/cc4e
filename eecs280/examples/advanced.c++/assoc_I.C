// Associative Array Using a Linked List and a struct Node
//
// assoc_I.C
//
// Written by: Charles Severance Jan 29, 1995 23:40

#include <iostream.h>
#include <String.h>
#include <stdlib.h>

struct Node {
    float index;
    int value;
    Node *next;
} ;

class List_Node {

public:

    Node * top; // A sorted linked list of Node structures

    List_Node() { top = NULL; } ; // Standard trivial constructor

    List_Node(const List_Node & parm) { // Deep Copy Constructor

      Node *sav; Node * old; Node * newptr;

      top = NULL; 
      old = parm.top;
      sav = NULL;
      while(old != NULL ) {
        newptr = new Node;
        newptr->index = old->index;
        newptr->value = old->value;
        newptr->next = NULL;
        if ( sav == NULL ) {
          top = newptr;
        } else {
          sav->next = newptr;
        }
        sav = newptr;
        old = old->next;
      } // End while
    }

    ~List_Node() { // Deep Destructor
       Node *sav; Node * ptr; 
       sav = NULL;
       ptr = top;
       while(ptr != NULL ) {
         delete sav;
         sav = ptr;
         ptr = ptr->next;
          }
       if ( sav != NULL ) delete sav;
     }

//  int Add(const float indexval, const int value)
//    Search through the list to find an entry with index value
//    If no entry is found,  add the entry and return TRUE
//    If the entry exists, return FALSE

  void Range(const float indexval, Node * & prev, Node * & ptr ) const {
    prev = NULL;
    ptr = top;
    while (ptr != NULL ) {
      if ( ptr->index == indexval ) return;
      if ( ptr->index > indexval ) return;
      prev = ptr;
      ptr = ptr->next;
    }
    return;
  }
   
  int Add(const float indexval, const int value) {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);

    if ( ptr != NULL && ptr->index == indexval ) return(FALSE); 

    newptr = new Node;
    newptr->next = ptr; 
    newptr->index = indexval;
    newptr->value = value;
    if ( prev == NULL ) { // Empty list or insert at the beginning
      top = newptr;
    } else {
      prev->next = newptr;  // Add at the end
    }
    return(TRUE);
  }
     
  int Delete(const float indexval) {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(FALSE); 
    if ( prev == NULL ) {
      top = ptr->next;
    } else {
      prev->next = ptr->next;
    }
    delete ptr;
    return(TRUE);
  }

  int Update(const float indexval, const int newvalue) {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(FALSE); 
    ptr->value = newvalue;
    return(TRUE);
  }

  int Find(const float indexval, int & contents)  const {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(FALSE); 
    contents = ptr->value;
    return TRUE;
  }

  int Top(float & indexval)  const {
    if ( top == NULL ) return(FALSE);
    indexval = top->index;
    return(TRUE);
  }
 
  int Next(const float indexval, float & nextind ) const {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);
    if ( ptr != NULL && ptr->index == indexval ) ptr = ptr->next;
    if ( ptr == NULL ) return(FALSE); 
    nextind = ptr->index;
    return TRUE;
  }

  void Print() const {
    Node *ptr;
    ptr = top;
    while (ptr != NULL ) {
      cout << "[" << ptr->index << "] = " << ptr->value << "\n";
      ptr = ptr->next;
    }
    return;
  }
    

}; // End of the class List_Node

class Arr_Node {
public:

  List_Node list;
  int AutoZeroFlag;

  Arr_Node() { AutoZeroFlag = FALSE; }

  int SetAutoZero(const int flag) { AutoZeroFlag = flag; }

  void Store(const float indexval, const int value) {
    if ( indexval <= 0 ) {
      cout << "Please do not use negative or zero index values\n";
      return;
    }
    if ( list.Update(indexval,value) ) return;
    list.Add(indexval,value);
  }

  void Delete(const float indexval) { list.Delete(indexval); }

  int Load(const float indexval) const {
    int ii;

    if ( list.Find(indexval,ii) ) return ii;  // Found

    if ( AutoZeroFlag ) return(0);

    cout << "Error - attempt to access non-existant element " << indexval 
         << "\n";
    return(0);
  }

  float First() const { 
    float ff;
    if ( list.Top(ff) ) return ff;
    return -1;
  }

  float Next(const float indexval) const {
    float ff;
    if ( list.Next(indexval,ff) ) return ff;
    return -1.0;
  }

};

main() {

 List_Node list;
 Arr_Node arr;
 int ii;
 float ff;

 list.Add(1.25,5);
 list.Add(1.40,9);
 list.Add(0.40,7);
 list.Add(6.40,7);

 cout << "pre-delete\n"; list.Print();

 cout << "calling the copy constructor...\n";

 List_Node list2(list);

 cout << "Deleteing 1.40 from first list...\n";

 list.Delete(1.40);

 cout << "first list post-delete\n"; list.Print();
 cout << "second list post-delete\n"; list2.Print();


 cout << "Updating 1.25 to 49\n";

 list.Update(1.25,49);

 cout << "post-update\n"; list.Print();

 cout << "Using the Find routine looking for 1.25\n";
 if ( list.Find(1.25,ii) ) {
   cout << "[" << 1.25 << "] = " << ii << "\n";
 } else {
   cout << 1.25 << " not found\n";
 }

 cout << "Using the Find routine looking for 2.25\n";
 if ( list.Find(2.25,ii) ) {
   cout << "[" << 2.25 << "] = " << ii << "\n";
 } else {
   cout << 2.25 << " not found\n";
 }

 cout << "Cruising through the data using member functions...\n";

 if ( list.Top(ff) ) {  // Check for non-empty list
   while(1) {
     if ( list.Find(ff,ii) ) {
       cout << "[" << ff << "] = " << ii << "\n";
     } else {
       cout << ff << " not found\n";
     }
     if ( ! list.Next(ff,ff) ) break;
   } // While
 } // if

 cout << "\nWorking with the array\n";

 arr.Store(-1.25,18);
 arr.Store(1.25,18);
 arr.Store(2.35,8);
 arr.Store(0.33,6);
 ff = 0.32;
 cout << "[" << ff << "] = " << arr.Load(ff) << "\n";
 ff = 0.33;
 cout << "[" << ff << "] = " << arr.Load(ff) << "\n";

 cout << "Associative Array Loop\n";
 for(ff=arr.First(); ff > 0.0 ; ff = arr.Next(ff) ) {
   cout << "[" << ff << "] = " << arr.Load(ff) << "\n";
 }

}


