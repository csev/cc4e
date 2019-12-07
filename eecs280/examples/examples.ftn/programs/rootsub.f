*
* rootsub - Find the roots of a function using subroutines and functions
*
*  Written by: C. Severance 18Mar92
*
      REAL ROOT
      INTEGER FOUND
*
      CALL CALCROOT(FOUND,ROOT,-3.0,0.0,0.1)
      PRINT 100,FOUND,ROOT
*
      CALL CALCROOT(FOUND,ROOT,-3.0,0.0,0.01)
      PRINT 100,FOUND,ROOT
*
      CALL CALCROOT(FOUND,ROOT,0.0,5.0,0.1)
      PRINT 100,FOUND,ROOT
*
      CALL CALCROOT(FOUND,ROOT,0.0,5.0,0.01)
      PRINT 100,FOUND,ROOT
*
      CALL CALCROOT(FOUND,ROOT,5.0,10.0,0.01)
      PRINT 100,FOUND,ROOT
*
100   FORMAT(1X,'Found = ',I3,'   Root= ',F9.4)
      END
*
      SUBROUTINE CALCROOT(GOOD,RT,START,END,DELTA)
      INTEGER GOOD
      REAL RT,START,END,DELTA
      REAL TMP
      REAL FUNC
*
      PRINT 100,START,END,DELTA
100   FORMAT(/1X,'Scanning from ',F8.2,' to ',F8.2,' by ',F8.2)
*
      GOOD = 0
      RT = 0.0
*
* Check the input parameters
*
      IF ( START.GT.END .OR. DELTA. LE. 0.0 ) THEN
        PRINT *,'Error in parameters - no root calculated'
        RETURN
      ENDIF
*
* Calculate the function value at the start and then loop until
* The function changes sign.  This point is returned as the root.
*
      TMP = FUNC(START)
*
      DO X=START,END,DELTA
        IF ( TMP*FUNC(X) .LT. 0 ) THEN
          RT = X
          GOOD = 1
          RETURN
        ENDIF
      ENDDO
*
* No root found
*    
      RETURN
      END
*
      REAL FUNCTION FUNC(VAL)
      REAL VAL
      FUNC = VAL ** 3 - 0.15 * VAL ** 2 - 2.8449 * VAL + 0.704975
      RETURN
      END
