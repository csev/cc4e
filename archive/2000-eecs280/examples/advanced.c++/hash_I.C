
#include <iostream.h>

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
/*11*/	        Node( Etype E = 0, Node *N = NULL ) :
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
/*29*/	    Etype operator ( ) ( ) const;

/*30*/	    // Member functions.
/*31*/	    int Is_Empty( ) const { return List_Head->Next == NULL; }
/*32*/	    virtual int Find( const Etype & X );
/*33*/	    // virtual int Find_Previous( const Etype & X );
/*34*/	    int In_List( const Etype & X ) { return( Find(X) ) ; } ; 
/*35*/	    void First( ) { if( List_Head->Next != NULL )
/*36*/	                            Current_Pos = List_Head->Next; }
/*37*/	    void Header( ) { Current_Pos = List_Head; }
/*38*/	    // int Remove( const Etype & X );
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
/* 4*/	inline Etype
/* 5*/	List<Etype>::
/* 6*/	operator ( ) ( ) const
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


#ifdef TEST_LIST

/* 1*/	// An example which instantiates two integer list classes.
/* 2*/	// The main routine does some insertions, removals, and copies,
/* 3*/	// Printing the list every now and then.
/* 4*/	// Print_List uses only the public functions.


/* 6*/	void
/* 7*/	Print_List( List<int> & L )
/* 8*/	{
/* 9*/	    if( L.Is_Empty( ) )
/*10*/	        cout << "Empty list.\n";
/*11*/	    else
/*12*/	        for( L.First( ); !L; L++ )
/*13*/	            cout << L( ) << "\n";
/*14*/	}


/* 1*/	main( )
/* 2*/	{
/* 3*/	    List<int> L1, L2;

/* 4*/	    cout << "( This should be empty )\n";
/* 5*/	    Print_List( L1 );
/* 6*/	    for( int i = 1; i <= 5; i++ )
/* 7*/	        L1.Insert_As_First_Element( i );
/* 8*/	    cout << "( This should be 5 4 3 2 1 )\n";
/* 9*/	    Print_List( L1 );

/*10*/	    for( i = 4;  i<= 6; i++ )
/*11*/	        if( L1.Find( i ) )
/*12*/	            cout << "Found " << L1( ) << "\n";
/*13*/	        else
/*14*/	            cout << i << " not found.\n";

/*23*/	}
#endif


#include <String.h>

/* 1*/	unsigned int
/* 2*/	Hash( const String & Key, const int H_Size )
/* 3*/	{
/* 4*/	    const char * Key_Ptr = Key;
/* 5*/	    unsigned int Hash_Val = 0;

/* 6*/	    while( *Key_Ptr )
/* 7*/	        Hash_Val = ( Hash_Val << 5 ) + *Key_Ptr++;

/* 8*/	    return Hash_Val % H_Size;
/* 9*/	}


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
/*19*/	    Element_Type operator ( ) ( ) const
/*20*/	        { return The_Lists[ Current_List ] ( ); }

/*21*/	    // Member functions.
/*22*/	    void Initialize_Table( );
/*23*/	    void Insert( const Element_Type & Key );
/*24*/	    // void Remove( const Element_Type & Key );
/*25*/	    int Find( const Element_Type & Key );
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


#ifdef DO_EQUAL
/* 1*/	template <class Element_Type>
/* 2*/	const Hash_Table<Element_Type> &
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	operator = ( const Hash_Table<Element_Type> & Value )
/* 5*/	{
/* 6*/	    if( this != &Value )
/* 7*/	    {
/* 8*/	        delete [ ] The_Lists;
/* 9*/	        H_Size = Value.H_Size;
/*10*/	        Allocate_Lists( );
/*11*/	        for( int i = 0; i < H_Size; i++ )
/*12*/	            The_Lists[ i ] = Value.The_Lists[ i ];
/*13*/	    }
/*14*/	    return *this;
/*15*/	}
#endif


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

/* 7*/	    if( !The_Lists[ Hash_Val ].In_List( Key ) )
/* 8*/	        The_Lists[ Hash_Val ].Insert_As_First_Element( Key );
/* 9*/	}


#ifdef DO_REMOVE
/* 1*/	template <class Element_Type>
/* 2*/	inline void
/* 3*/	Hash_Table<Element_Type>::
/* 4*/	Remove( const Element_Type & Key )
/* 5*/	{
/* 6*/	    The_Lists[ Hash( Key, H_Size ) ].Remove( Key );
/* 7*/	}
#endif

#include <String.h>

main () {

  Hash_Table<String> Htable(131);

  cout << "Hi there...\n";

  Htable.Insert("dog");
  Htable.Insert("cat");
  Htable.Insert("pup");

  if ( Htable.Find("cat") ) { 
    cout << "cat Found\n";
  } else {
    cout << "cat Not found\n";
  }

  if ( Htable.Find("frog") ) { 
    cout << "frog Found\n";
  } else {
    cout << "frog Not found\n";
  }

}
