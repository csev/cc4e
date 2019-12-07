// Associative Array using a linked list and operator overloading
// and Templates
//
// assoc_III.C
//
// Written by: Charles Severance Tue Feb 21 10:41:13 EST 1995

#include <iostream.h>
#include <String.h>
#include <stdlib.h>
#include <assert.h>

// The Node class - In this version we provide some basic operators
// IT - Index type DT - Data Type

template <class IT, class DT>
class Node {

private:
    IT index;
    Node *next;

public:
    DT value;

    Node () { next = NULL; } 
    Node (IT fval) { next = NULL; index=fval; }
    Node (IT fval, DT inval ) { next = NULL; index=fval; value=inval; }

    Node (const Node & parm) { // Copy Constructor
      next = NULL;
      index = parm.index;
      value = parm.value;
    }
 
    IT Index() { return index; }

    void operator = ( DT inval ) { value = inval; } 

    operator const DT ( ) const { return value; }  
   
    friend class List_Node<IT,DT>;

    friend ostream & operator << ( ostream & os, const Node & parm ) ;

};

// Friend function to print a node

template <class IT, class DT>
ostream & operator << ( ostream & os, const Node<IT,DT> & parm ) {
  os << "[" << parm.index << "]=" << parm.value ;
  return os;
}


template <class IT, class DT>
class List_Node {

private:

    Node<IT,DT> * top; // A sorted linked list of Node structures

public:

    List_Node() { top = NULL; } // Typical simple Constructor

    List_Node(const List_Node & parm) { // Deep Copy Constructor

      Node<IT,DT> *sav; Node<IT,DT> * old; Node<IT,DT> * newptr;

      top = NULL;
      old = parm.top;
      sav = NULL;
      while(old != NULL ) {
        newptr = new Node<IT,DT>(*old);
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
    Node<IT,DT> *sav; Node<IT,DT> * ptr; 
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

  void Range(const IT indexval, Node<IT,DT> * & prev, Node<IT,DT> * & ptr ) 
                                                                     const {
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

  int Delete(const IT indexval) {
    Node<IT,DT> *ptr; Node<IT,DT> *prev; Node<IT,DT> *newptr;
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
    Node<IT,DT> *ptr;
    ptr = top;
    while (ptr != NULL ) {
      cout << "[" << ptr->index << "] = " << ptr->value << "\n";
      ptr = ptr->next;
    }
    return;
  }
    
//  Set of routines which operate on and return Node addresses
 
// Note these return pointers to Nodes and may return a NULL pointer

//  Add(const IT indexval, const DT value)
//    Search through the list to find an entry with index value
//    If no entry is found,  add the entry and return TRUE
//    If the entry exists, return FALSE
    
  Node<IT,DT> * PtrAdd(const IT indexval, const DT value) {
    Node<IT,DT> *ptr; Node<IT,DT> *prev; Node<IT,DT> *newptr;
    Range(indexval,prev,ptr);

    if ( ptr != NULL && ptr->index == indexval ) return(NULL); 

    newptr = new Node<IT,DT>;
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
     
    
  Node<IT,DT> * PtrFind(const IT indexval)  const {
    Node<IT,DT> *ptr; Node<IT,DT> *prev; Node<IT,DT> *newptr;
    Range(indexval,prev,ptr);
    if ( ptr == NULL || ptr->index != indexval ) return(NULL); 
    return ptr;
  }
 
// Iteration tools - Note these return pointers to Nodes and may

  Node<IT,DT> * PtrTop() const { return top; } 

  Node<IT,DT> * PtrNext(const Node<IT,DT> * current ) const {
    if ( current == NULL ) return NULL;
    return(current->next);
  }

}; // End of the class List_Node

// The associative array class

template <class IT, class DT>
class Arr_Node {

private:

  List_Node<IT,DT> list;
  Node<IT,DT> *CurrentIter;  // Used to do iterations

public:

  Arr_Node() { CurrentIter = NULL; }

// De-Reference Operator - This will create entries which don't exist

// Note that once we return the reference, the Node = operator
// will be used to do the actual assignment

  Node<IT,DT> & operator [ ] (const IT indexval) {
    Node<IT,DT> *ptr;

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

  void Delete(const IT indexval) { list.Delete(indexval); }

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

  DT Value () const { return CurrentIter->value; }

  IT Index () const { return CurrentIter.Index(); }

  friend ostream & operator << ( ostream & os, const Arr_Node & arr ) ;

};

// Friend function to print the current values in the array
// Note does not use the iteration variable CurrentIter

template <class IT, class DT>
ostream & operator << ( ostream & os, const Arr_Node<IT,DT> & arr ) {
  Node<IT,DT> *localiter;

  for(localiter=arr.list.PtrTop(); localiter != NULL; 
                                 localiter = arr.list.PtrNext(localiter)  ) {
    os << *(localiter) << "\n" ; 
  }
  return os;
}


// Main Program - Test Suite

main() {

 Arr_Node<float,int> arr;
 float f;
 int i;

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

 cout << "Try Output operator for the whole array: cout << arr\n";
 cout << arr ;

 cout << "Print arr[1.2] using cout << arr[1.2]\n" << arr[1.2] << "\n";

 cout << "\n" << "Lets do some other combinations...\n";
 cout << "Index by strings store floats\n";

 Arr_Node<String,float> arrsf;

 arrsf["ralph"] = 3.14;
 arrsf["amy"] = 1.11;
 arrsf.Print();

 cout << "Index by ints, store strings (sparse array)\n";

 Arr_Node<int,String> arris;

 arris[12394948] = "elmo";
 arris[-1828737] = "doug";
 arris[0] = "bigbird";
 arris.Print();

}
