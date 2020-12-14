*
* Program factable - compute the factorial table
*
* Written by - Charles Severance 12Mar92
*
      INTEGER I,N,FAC
*
* Print heading
*
      PRINT 100
      PRINT 200
*
*  Loop thruogh the numbers 1-10 and print out the factorials
*
      DO N=1,10
        FAC = 1
        DO I=2,N
          FAC = FAC * I
        ENDDO
        PRINT 300,N,FAC
      ENDDO
*
100   FORMAT('      NUMBER      FACTORIAL') 
200   FORMAT('      ------      ---------')
300   FORMAT(6X,I6,6X,I10)
      END
