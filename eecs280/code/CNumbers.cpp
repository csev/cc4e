// CNumbers.cpp

// Debug messages (beginning with "==>") should be removed

#include <iostream>
#include <strstream>
#include <iomanip>

using namespace std;

class ComplexNumber
{
	public:

		ComplexNumber(double r, double i);
		ComplexNumber(double r);
		ComplexNumber();

		void setNumber(double r, double i);
		void getNumber(double& r, double& i);

		friend ComplexNumber operator + 
				(ComplexNumber n1, const ComplexNumber& n2);
		friend ComplexNumber operator - 
				(ComplexNumber n1, const ComplexNumber& n2);
		friend ComplexNumber operator * 
				(const ComplexNumber& n1, const ComplexNumber& n2);
		friend ComplexNumber operator / 
				(const ComplexNumber& n1, const ComplexNumber& n2);

		ComplexNumber& operator += (ComplexNumber n);

		friend ostream& operator << 
				(ostream& outstr, const ComplexNumber& n);
		friend istream& operator >> 
				(istream& instr, ComplexNumber& n);

	private:
		double RealPart;
		double ImaginaryPart;
};


int main()
{
	cout.setf(ios::fixed);
	cout.setf(ios::showpoint);
	cout.precision(1);
	
	ComplexNumber x, y;
	char response;
	
	do {
		cout << "Enter x: ";
		cin >> x;
		if( cin.eof() || cin.fail() )
			exit(1);
		
		cout << "Enter y: ";
		cin >> y;
		if( cin.eof() || cin.fail() )
			exit(1);
		
		cout << "x: " << x << endl;
	
		cout << "y: " << y << endl;
	
		cout << "x + y = " << (x + y) << endl;
		cout << "x - y = " << (x - y) << endl;
		cout << "x * y = " << (x * y) << endl;
		cout << "x / y = " << (x / y) << endl;

		cout << "Do it again? (y/n) ";
		cin >> response;
	} while (response == 'y');

	return 0;	
}


ComplexNumber::ComplexNumber(double r, double i)
{
	cout << " ==> constructor for ComplexNumber(" << r << ", " 
		  << i << ")" << endl;
	setNumber(r, i);
}


ComplexNumber::ComplexNumber(double r)
{
	cout << " ==> constructor for ComplexNumber(" << r << ")" 
		  << endl;
	ComplexNumber(r, 0.0);
}


ComplexNumber::ComplexNumber()
{
	cout << " ==> constructor for ComplexNumber()" << endl;
	ComplexNumber(0.0, 0.0);
}


void ComplexNumber::setNumber(double r, double i)
{
	RealPart 	= r;
	ImaginaryPart 	= i;
}


void ComplexNumber::getNumber(double& r, double& i)
{
	r = RealPart;
	i = ImaginaryPart;
}


ComplexNumber operator + 
		(ComplexNumber n1, const ComplexNumber& n2)
{
   cout << " ==> addition: " << n1 << " + " << n2 << endl;

   n1.RealPart += n2.RealPart;
   n1.ImaginaryPart += n2.ImaginaryPart;

   return n1;
}


ComplexNumber& ComplexNumber::operator += (ComplexNumber n)
{
	RealPart += n.RealPart;
	ImaginaryPart += n.ImaginaryPart;
	
	return *this;
}

ComplexNumber operator - 
		(ComplexNumber n1, const ComplexNumber& n2)
{
   n1.RealPart -= n2.RealPart;
   n1.ImaginaryPart -= n2.ImaginaryPart;

   return n1;
}


ComplexNumber operator * 
		(const ComplexNumber& n1, const ComplexNumber& n2)
{
   return ComplexNumber( n1.RealPart * n2.RealPart 
   			 - n1.ImaginaryPart * n2.ImaginaryPart, 
   			 n1.RealPart * n2.ImaginaryPart 
   			 + n1.ImaginaryPart * n2.RealPart );
}


ComplexNumber operator / 
		(const ComplexNumber& n1, const ComplexNumber& n2)
// To divide n1 (r1 + i1*i) by n2 (r2 + i2*i), we multiply
// numerator and denominator by the conjugate of n2 (r2 - i2*i).
// The result has a denominator with no imaginary parts.
{
   double div = n2.RealPart * n2.RealPart 
   	        + n2.ImaginaryPart * n2.ImaginaryPart;
   
   double rPart = (n1.RealPart * n2.RealPart 
   		   + n1.ImaginaryPart * n2.ImaginaryPart) / div;
   double iPart = (n1.RealPart * n2.ImaginaryPart 
   		   - n1.ImaginaryPart * n2.RealPart) / div;
	
   return ComplexNumber( rPart, iPart );
}


ostream& operator << (ostream& outstr, const ComplexNumber& n)
{
	if( n.ImaginaryPart == 0.0 )
		outstr << n.RealPart;
	else
		outstr << '(' << n.RealPart << ',' 
		       << n.ImaginaryPart << ')' << ends;	
	
	return outstr;
}

/*
ostream& operator << (ostream& outstr, const ComplexNumber& n)
{
	char s[42];
	ostrstream outbuf(s, 42);
	
	outbuf.flags( outstr.flags() );
	
	if( n.ImaginaryPart == 0.0 )
		outbuf << n.RealPart << ends;
	else
		outbuf << '(' << n.RealPart << ',' 
		       << n.ImaginaryPart << ')' << ends;

	outstr << s;
	
	return outstr;
}
*/

istream& operator >> (istream& instr, ComplexNumber& n)
{
	double r(0), i(0);
	char ch(0);
	instr >> ch;
	if( ch == '(' )
	{
		cin >> r >> ch;
		if( ch == ',' ) 
			instr >> i >> ch;
		if( ch != ')' )
			instr.clear(ios::badbit);	// set state
	}
	else
	{
		instr.putback(ch);
		instr >> r;
	}
	
	if(instr)
		n.setNumber( r, i );
	
	return instr;
}


