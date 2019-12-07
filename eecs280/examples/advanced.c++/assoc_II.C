// Associative Array using a linked list and operator overloading
//
// assoc_II.C
//
// Written by: Charles Severance Mon Feb 20 13:43:08 EST 1995

#include <iostream.h>
#include <String.h>
#include <stdlib.h>
#include <assert.h>

// The Node class - In this version we provide some basic operators

class Node {

private:
    float index;
    Node *next;

public:
    int value;

    Node (float fval = 0.0, int inval = 0 ) 
       { next = NULL; index=fval; value=inval; }

    Node (const Node & parm) { // Copy Constructor
      next = NULL;
      index = parm.index;
      value = parm.value;
    }
 
    float Index() { return index; }

    void operator = ( int inval ) { value = inval; } 

    operator const int ( ) const { return value; }  
   
    friend class List_Node;

    friend ostream & operator << ( ostream & os, const Node & parm ) ;

};

// Friend function to print a node

ostream & operator << ( ostream & os, const Node & parm ) {
  os << "[" << parm.index << "]=" << parm.value ;
  return os;
}

class List_Node {

private:

    Node * top; // A sorted linked list of Node structures

public:

    List_Node() { top = NULL; } // Typical simple Constructor

    List_Node(const List_Node & parm) { // Deep Copy Constructor

      Node *sav; Node * old; Node * newptr;

      top = NULL;
      old = parm.top;
      sav = NULL;
      while(old != NULL ) {
        newptr = new Node(*old);
        if ( sav == NULL ) {
          top = newptr;
        } else {
          sav->next = newptr;
        }
        sav = newptr;
        old = old->next;
      } // End while
    }


//  Destructor - Must work properly - deallocate ALL of the allocated space

  ~List_Node() { 
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

// Member function Range - Searches for the location in the list
// for a particular value.  ptr points to the entry which is >= the 
// index value.  prev points to the entry which is < the index value.
// If prev is NULL it means the beginning of the list.  If ptr is NULL
// it indicates the end of the list.  If both are NULL it is an empty list.

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

  void Print() const {
    Node *ptr;
    ptr = top;
    while (ptr != NULL ) {
      cout << "[" << ptr->index << "] = " << ptr->value << "\n";
      ptr = ptr->next;
    }
    return;
  }
    
//  Set of routines which operate on and return Node addresses
 
// Note these return pointers to Nodes and may return a NULL pointer

//  Add(const float indexval, const int value)
//    Search through the list to find an entry with index value
//    If no entry is found,  add the entry and return TRUE
//    If the entry exists, return FALSE
    
  Node * PtrAdd(const float indexval, const int value) {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);

    if ( ptr != NULL && ptr->index == indexval ) return(NULL); 

    newptr = new Node;
    newptr->next = ptr; 
    newptr->index = indexval;
    newptr->value = value;
    if ( prev == NULL ) { // Empty list or insert at the beginning
      top = newptr;
    } else {
      prev->next = newptr;  // Add at the end
    }
    return(newptr);
  }
     
    
  Node * PtrFind(const float indexval)  const {
    Node *ptr; Node *prev; Node *newptr;
    Range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(NULL); 
    return ptr;
  }
 
// Iteration tools - Note these return pointers to Nodes and may

  Node * PtrTop() const { return top; } 

  Node * PtrNext(const Node * current ) const {
    if ( current == NULL ) return NULL;
    return(current->next);
  }

}; // End of the class List_Node

// The associative array class

class Arr_Node {

private:

  List_Node list;
  Node *CurrentIter;  // Used to do iterations

public:

  Arr_Node() { CurrentIter = NULL; }

// De-Reference Operator - Note this will create empty entries

// Note that once we return the reference, the Node = operator
// will be used to do the actual assignment

  Node & operator [ ] (const float indexval) {
    Node *ptr;

    assert ( indexval > 0.0 );

    ptr = list.PtrFind(indexval);  // May return a NULL
    if ( ptr == NULL ) {
      ptr = list.PtrAdd(indexval,0);  // Better not return a NULL
      if ( ptr == NULL ) {
        cout << "Error in Arr_Node::operator [], unable to add element\n";
        exit(-1);
      }
    } 

    // At this point ptr should not be NULL as the following will seg-fault
    // if ptr is NULL

    return *ptr;
      
  }

  void Delete(const float indexval) { list.Delete(indexval); }

  void Print() { list.Print(); } 

// These member functions are used to implement a simple iteration tool
// These tools are not sufficient to handle nested loops though

  void First()  { CurrentIter = list.PtrTop(); } ; 

  const int Data () { return ( CurrentIter != NULL ) ; }  

  void Next () {
    if ( CurrentIter != NULL ) CurrentIter = list.PtrNext( CurrentIter ) ;
  }

  void operator ++ () { Next(); }  // An alias

// These member functions allow the current value and index to be accessed

  int Value () const { 
    if ( CurrentIter != NULL ) {
      return CurrentIter->value;
    }
    return 0;
  }

  float Index () const { 
    if ( CurrentIter != NULL ) {
      return CurrentIter.Index();
    }
    return 0.0;
  }

  friend ostream & operator << ( ostream & os, const Arr_Node & arr ) ;

};

// Friend function to print the current values in the array
// Note does not use the iteration variable CurrentIter

ostream & operator << ( ostream & os, const Arr_Node & arr ) {
  Node *localiter;

  for(localiter=arr.list.PtrTop(); localiter != NULL; 
                                 localiter = arr.list.PtrNext(localiter)  ) {
    os << *(localiter) << "\n" ; 
  }
  return os;
}


// Main Program - Test Suite

main() {

 Arr_Node arr;
 float f;
 int i;

 cout << "Here we go...\n";

 arr[1.2] = 3;

 cout << "First list...\n";

 arr.Print();

 for(f=0.2;f<100.0;f=f*2.2) {
   i = (int) ( f / 2.0 ) ;
   arr[f] = i;
 }

 cout << "List after the for loop...\n";

 arr.Print();

 cout << "Try a for loop through everything using ++ operator...\n";
 for ( arr.First() ; arr.Data() ; arr++ ) {
    cout << "Found " << arr.Index() << " Value=" << arr.Value() << "\n";
 }

 cout << "Print out numbers with index < 15.0 using Next member function\n";
 for ( arr.First() ; arr.Data() && arr.Index() < 15.0 ; arr.Next() ) {
    cout << "Found " << arr.Index() << " Value=" << arr.Value() << "\n";
 }
 
 cout << "Try Output operator for the whole array: cout << arr\n";
 cout << arr ;

 cout << "Print arr[1.2] using cout << arr[1.2]\n" << arr[1.2] << "\n";

 cout << "Now lets blow up with an assert error...\n";

 arr [-1.0] = 911;

}


