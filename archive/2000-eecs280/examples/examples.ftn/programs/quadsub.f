*
* Program qadsub - calculate the quadratic formula roots using a subroutine
*
* Written by - C. Severance 12Mar92
*
      REAL A,B,C,ROOT1,ROOT2
      REAL Q,R,S,ROOTA,ROOTB
*
      PRINT *,'Enter A,B,C -'
      READ *,A,B,C
*
      CALL QUADSUB(ROOT1,ROOT2,A,B,C)
*
      PRINT *,'ROOT1 = ',ROOT1
      PRINT *,'ROOT2 = ',ROOT2
*
* Lets do it again
*
      PRINT *,'Enter Q,R,S -'
      READ *,Q,R,S
*
      CALL QUADSUB(ROOTA,ROOTB,Q,R,S)
*
      PRINT *,'ROOTA = ',ROOTA
      PRINT *,'ROOTB = ',ROOTB
*
      END
      SUBROUTINE QUADSUB(R1,R2,A,B,C)
      REAL R1,R2,A,B,C
      REAL TD
*
      TD = SQRT( B*B - 4 * A * C )
      R1 = ( -1.0*B + TD ) /  ( 2 * A )
      R2 = ( -1.0*B - TD ) /  ( 2 * A )
*
      RETURN
      END
