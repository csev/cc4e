
#include <iostream.h>

// Functions added so things work /crs

void Error(char *str) { cout << str << '\n'; } 
void Warn(char *str) { cout << str << '\n'; } 

/* 1*/	template <class Etype>
/* 2*/	class List
/* 3*/	{
/* 4*/	  protected:
/* 5*/	    // The list is a linked list with a header node.

/* 6*/	    struct Node
/* 7*/	    {
/* 8*/	        Etype Element;
/* 9*/	        Node *Next;

/*10*/	        // Constructor for node.
                Node() { Next = NULL; } ; 
/*11*/	        Node( Etype E = 0 , Node *N = NULL ) :
/*12*/	            Element( E ), Next( N ) { }
/*13*/	    };

/*14*/	    Node *List_Head;
/*15*/	    Node *Current_Pos;

/*16*/	    // void Destroy_List( );	// An incorrect routine in Fig. 3.15.
/*17*/	    // void Delete_List( );	// The  correct routine in Fig. 3.16.

/*18*/	  public:
/*19*/	    // Constructors.
/*20*/	    List( ) : List_Head ( new Node ), Current_Pos( List_Head ) { }

/*23*/	    // Destructor.
/*24*/	    // virtual ~List( ) { Delete_List( ); }

/*25*/	    // Operators.
/*26*/	    const List & operator = ( List & Value );
/*27*/	    const List & operator ++ ( );
/*28*/	    int operator ! ( ) const;
/*29*/	    Etype & operator ( ) ( ) ;  // Deleted const added &

/*30*/	    // Member functions.
/*31*/	    int Is_Empty( ) const { return List_Head->Next == NULL; }
/*32*/	    virtual int Find( const Etype & X );
/*33*/	    // virtual int Find_Previous( const Etype & X );
/*34*/	    int In_List( const Etype & X ) { return( Find(X) ) ; } ; 
/*35*/	    void First( ) { if( List_Head->Next != NULL )
/*36*/	                            Current_Pos = List_Head->Next; }
/*37*/	    void Header( ) { Current_Pos = List_Head; }
/*39*/	    virtual void Insert( const Etype & X );
/*40*/	    virtual void Insert_As_First_Element( const Etype & X );
/*41*/	};


/* 1*/	// Advance the current position.

/* 2*/	template <class Etype>
/* 3*/	inline const List<Etype> &
/* 4*/	List<Etype>::
/* 5*/	operator ++( )
/* 6*/	{
/* 7*/	    if( Current_Pos != NULL )
/* 8*/	        Current_Pos = Current_Pos->Next;
/* 9*/	    return *this;
/*10*/	}


/* 1*/	// Retrieve element in the current position.
/* 2*/	// Return value is undefined if current position is NULL.

/* 3*/	template <class Etype>
/* 4*/	inline Etype &               // added & removed const /crs
/* 5*/	List<Etype>::
/* 6*/	operator ( ) ( ) 
/* 7*/	{
/* 8*/	    if( Current_Pos != NULL )
/* 9*/	        return Current_Pos->Element;
/*10*/	    else
/*11*/	        return List_Head->Element;
/*12*/	}


/* 1*/	// Check if current position is not NULL.

/* 2*/	template <class Etype>
/* 3*/	inline int
/* 4*/	List<Etype>::
/* 5*/	operator !( ) const
/* 6*/	{
/* 7*/	    return Current_Pos != NULL;
/* 8*/	}


/* 1*/	// Assuming use of header node, find X.
/* 2*/	// If found, return TRUE and set the current position.

/* 3*/	template <class Etype>
/* 4*/	int
/* 5*/	List<Etype>::
/* 6*/	Find( const Etype & X )
/* 7*/	{
/* 8*/	    Node *P;
/* 9*/	    for( P = List_Head->Next; P != NULL; P = P->Next )
/*10*/	        if( P->Element == X )
/*11*/	        {
/*12*/	            Current_Pos = P;
/*13*/	            return 1;
/*14*/	        }

/*15*/	    return 0;
/*16*/	}

/* 1*/	// Insert X after the current position.
/* 2*/	// X becomes the current element.
/* 3*/	// Header implementation assumed.

/* 4*/	template <class Etype>
/* 5*/	void
/* 6*/	List<Etype>::
/* 7*/	Insert( const Etype & X )
/* 8*/	{
/* 9*/	    Node *P = new Node( X, Current_Pos->Next );

/*10*/	    if( P == NULL )
/*11*/	        Error( "Out of space" );
/*12*/	    else
/*13*/	    {
/*14*/	        Current_Pos->Next = P;
/*15*/	        Current_Pos = Current_Pos->Next;
/*16*/	    }
/*17*/	}

/* 4*/	template <class Etype>
/* 5*/	void
/* 6*/	List<Etype>::
/* 7*/	Insert_As_First_Element( const Etype & X )
/* 8*/	{
/* 9*/	    Node *P = new Node( X, List_Head->Next );

/*10*/	    if( P == NULL )
/*11*/	        Error( "Out of space" );
/*12*/	    else
/*13*/	    {
/*14*/	        List_Head->Next = P;
/*15*/	        Current_Pos = P;
/*16*/	    }
/*17*/	}

/* 1*/	static const Default_Size = 101;

/* 2*/	template <class Element_Type>
/* 3*/	class Hash_Table
/* 4*/	{
/* 5*/	  private:
/* 6*/	    unsigned int H_Size;
/* 7*/	    List<Element_Type> *The_Lists;
/* 8*/	    unsigned int Current_List;	// The last list accessed.

/* 9*/	    void Allocate_Lists( );

/*10*/	  public:
/*11*/	    // Constructors.
/*12*/	    Hash_Table( unsigned int Initial_Size = Default_Size );

/*15*/	    // Destructor.
/*16*/	    ~Hash_Table( ) { delete [ ] The_Lists; }

/*17*/	    // Operators.
/*18*/	    //const Hash_Table & operator = ( const Hash_Table & Value );
/*19*/	    Element_Type & operator ( ) ( )  // Removed const added & /crs
/*20*/	        { return The_Lists[ Current_List ] ( ); }

/*21*/	    // Member functions.
/*22*/	    void Initialize_Table( );
/*23*/	    void Insert( const Element_Type & Key );
/*25*/	    int Find( const Element_Type & Key );

/*CS*/      void Dump();
/*26*/	};


/* 1*/	template <class Element_Type>
/* 2*/	void
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	Allocate_Lists( )
/* 5*/	{
/* 6*/	    The_Lists = new List<Element_Type> [ H_Size ];
/* 7*/	    if( The_Lists == NULL )
/* 8*/	        Error( "Out of space!!" );
/* 9*/	}

/*10*/	template <class Element_Type>
/*11*/	Hash_Table<Element_Type>::
/*12*/	Hash_Table( unsigned int Initial_Size )
/*13*/	{
/*14*/	    H_Size = Initial_Size;
/*15*/	    Allocate_Lists( );
/*16*/	}


/* 1*/	template <class Element_Type>
/* 2*/	void
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	Initialize_Table( )
/* 5*/	{
/* 6*/	    delete [ ] The_Lists;
/* 7*/	    Allocate_Lists( );
/* 8*/	}


/* 1*/	template <class Element_Type>
/* 2*/	inline int
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	Find( const Element_Type & Key )
/* 5*/	{
/* 6*/	    unsigned int Hash_Val = Hash( Key, H_Size );

/* 7*/	    if( The_Lists[ Hash_Val ].Find( Key ) )
/* 8*/	    {
/* 9*/	        Current_List = Hash_Val;
/*10*/	        return 1;
/*11*/	    }
/*12*/	    return 0;
/*13*/	}


/* 1*/	template <class Element_Type>
/* 2*/	inline void
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	Insert( const Element_Type & Key )
/* 5*/	{
/* 6*/	    unsigned int Hash_Val = Hash( Key, H_Size );

/* 7*/	    if( !The_Lists[ Hash_Val ].In_List( Key ) ) {
/* 8*/	        The_Lists[ Hash_Val ].Insert_As_First_Element( Key );
            }
/* 9*/	}

/*CS*/  // New Member function Dump

/*CS*/	template <class Element_Type>
/*CS*/  void
/*CS*/	Hash_Table<Element_Type>::
/*CS*/	Dump( )
/*CS*/	{
/*CS*/	    int i;

/*CS*/      for ( i=0; i< H_Size; i++ ) {
/*CS*/	      if( The_Lists[ i ].Is_Empty() ) continue;
/*CS*/        cout << "Bucket " << i << "\n";
/*CS*/	      for ( The_Lists[i].First(); !The_Lists[i]; ++The_Lists[i]) {  
/*CS*/           cout << " " << The_Lists[ i ] ( ) << "\n";
/*CS*/        } // For the list
/*CS*/     } // for H_Size
/*CS*/	}


#include <String.h>

// My class

class myclass {
  public:

  String word;
  int count;

  myclass() { count = 0; }  ;  // Regular constructor

  myclass(myclass & mc) { word = mc.word; count = mc.count; } ; // Copy

  int operator == (const myclass & value)  // Overload for list operation
    { return( this->word == value.word ) ; } ;
};

// Overload the << operator to easily print myclass values out

ostream & operator << ( ostream & os, const myclass & mc ) {
  os << mc.word << " (" << mc.count << ")" ;
  return os;
}

// My Hash Function - Note the type of the first argument

/* 1*/	unsigned int
/* 2*/	Hash( const myclass & Key, const int H_Size )
/* 3*/	{
/* 4*/	    const char * Key_Ptr = Key.word;   // What to use for hash
/* 5*/	    unsigned int Hash_Val = 0;

/* 6*/	    while( *Key_Ptr )
/* 7*/	        Hash_Val = ( Hash_Val << 5 ) + *Key_Ptr++;

/* 8*/	    return Hash_Val % H_Size;
/* 9*/	}

// Main Program

main () {

  Hash_Table<myclass> Htable(131);
  myclass x;
  String str;

  while ( cin >> x.word ) {
    x.count = 1;  // In case
    if ( Htable.Find(x) ) {
      Htable().count ++;
    } else {
      Htable.Insert(x);  
    }
  }

  Htable.Dump();

}
