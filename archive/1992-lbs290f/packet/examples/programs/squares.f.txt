*
* squares - Print a table of squares from 1 to 10
*
*  Written by: C. Severance 16Mar92
*
* Declare the variables:
*
      INTEGER I
      REAL X,XSQ
*
* Generate the table using a DO LOOP
*
      PRINT *,'The first table'
      DO I=1,10
        X = I
        XSQ = X ** 2
        PRINT *,I,XSQ
      ENDDO
*
* Print out the table a different way - Use a real number for the index
*
      PRINT *,'The second table'
      DO X=1.0,10.0
        XSQ = X ** 2
        PRINT *,X,XSQ
      ENDDO
      END
