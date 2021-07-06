// Associative Array using a linked list and operator overloading
// Using inheritance from one class to another but no templates
//
// assoc_IV.C
//
// Written by: Charles Severance Tue Feb 21 10:40:55 EST 1995

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
 
    float index() { return index; }

    void operator = ( int inval ) { value = inval; } 

    operator const int ( ) const { return value; }  
   
    friend class ListNode;

    friend ostream & operator << ( ostream & os, const Node & parm ) ;

};

// Friend function to print a node

ostream & operator << ( ostream & os, const Node & parm ) {
  os << "[" << parm.index << "]=" << parm.value ;
  return os;
}

class ListNode {

protected:   // Necessary to allow derived classes to access the information

    Node * top; // A sorted linked list of Node structures

public:

    ListNode() { top = NULL; } // Typical simple Constructor

    ListNode(const ListNode & parm) { // Deep Copy Constructor

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

  ~ListNode() { 
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

// Member function range - Searches for the location in the list
// for a particular value.  ptr points to the entry which is >= the 
// index value.  prev points to the entry which is < the index value.
// If prev is NULL it means the beginning of the list.  If ptr is NULL
// it indicates the end of the list.  If both are NULL it is an empty list.

  void range(const float indexval, Node * & prev, Node * & ptr ) const {
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

  int delete(const float indexval) {
    Node *ptr; Node *prev; Node *newptr;
    range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(FALSE); 
    if ( prev == NULL ) {
      top = ptr->next;
    } else {
      prev->next = ptr->next;
    }
    delete ptr;
    return(TRUE);
  }

  void print() const {
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

//  ptradd(const float indexval, const int value)
//    Search through the list to find an entry with index value
//    If no entry is found,  add the entry and return 
//    the pointer to the entry
//    If the entry exists, return NULL
    
  Node * ptradd(const float indexval, const int value) {
    Node *ptr; Node *prev; Node *newptr;
    range(indexval,prev,ptr);

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
     
    
  Node * ptrfind(const float indexval)  const {
    Node *ptr; Node *prev; Node *newptr;
    range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(NULL); 
    return ptr;
  }
 
// Iteration tools - Note these return pointers to Nodes and may

  Node * ptrtop() const { return top; } 

  Node * ptrnext(const Node * current ) const {
    if ( current == NULL ) return NULL;
    return(current->next);
  }

}; // End of the class ListNode

// The associative array class - Derived from the ListNode class

class ArrNode : public ListNode {

private:

  Node *CurrentIter;  // Used to do iterations

public:

  ArrNode() { CurrentIter = NULL; }

// De-Reference Operator - If an entry does not exist, create it

// Note that once we return the reference, the Node = operator
// will be used to do the actual assignment

  Node & operator [ ] (const float indexval) {
    Node *ptr;

    ptr = ptrfind(indexval);  // May return a NULL
    if ( ptr == NULL ) {
      ptr = ptradd(indexval,0);  // Better not return a NULL
      if ( ptr == NULL ) {
        cout << "Error in ArrNode::operator [], unable to add element\n";
        exit(-1);
      }
    } 

    // At this point ptr should not be NULL as the following will seg-fault
    // if ptr is NULL

    return *ptr;
      
  }

// These member functions are used to implement a simple iteration tool
// These tools are not sufficient to handle nested loops though

  void first()  { CurrentIter = ptrtop(); } ; 

  const int data () { return ( CurrentIter != NULL ) ; }  

  void next () {
    if ( CurrentIter != NULL ) CurrentIter = ptrnext( CurrentIter ) ;
  }

  void operator ++ () { next(); }  // An alias

// These member functions allow the current value and index to be accessed

  int value () const { 
    if ( CurrentIter != NULL ) {
      return CurrentIter->value;
    }
    return 0;
  }

  float index () const { 
    if ( CurrentIter != NULL ) {
      return CurrentIter.index();
    }
    return 0.0;
  }

  friend ostream & operator << ( ostream & os, const ArrNode & arr ) ;

};

// Friend function to print the current values in the array
// Note does not use the iteration variable CurrentIter

ostream & operator << ( ostream & os, const ArrNode & arr ) {
  Node *localiter;

  for(localiter=arr.ptrtop(); localiter != NULL; 
                                 localiter = arr.ptrnext(localiter)  ) {
    os << *(localiter) << "\n" ; 
  }
  return os;
}


// Main Program - Test Suite

main() {

 ArrNode arr;
 float f;
 int i;

 cout << "Here we go...\n";

 arr[1.2] = 3;

 cout << "First list...\n";

 arr.print();

 for(f=0.2;f<100.0;f=f*2.2) {
   i = (int) ( f / 2.0 ) ;
   arr[f] = i;
 }

 cout << "List after the for loop...\n";

 arr.print();

 cout << "Try a for loop through everything using ++ operator...\n";
 for ( arr.first() ; arr.data() ; arr++ ) {
    cout << "Found " << arr.index() << " Value=" << arr.value() << "\n";
 }

 cout << "Print out numbers with index < 15.0 using Next member function\n";
 for ( arr.first() ; arr.data() && arr.index() < 15.0 ; arr.next() ) {
    cout << "Found " << arr.index() << " value=" << arr.value() << "\n";
 }
 
 cout << "Try Output operator for the whole array: cout << arr\n";
 cout << arr ;

 cout << "Print arr[1.2] using cout << arr[1.2]\n" << arr[1.2] << "\n";

 cout << "Now lets blow up with an assert error...\n";

 arr [-1.0] = 911;

}


