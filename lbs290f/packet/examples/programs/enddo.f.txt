*
*  Program enddo - demonstrate how the END DO FORTRAN extension
*  works.
*
*  Written by: Charles Severance - 10Mar92
*
      integer I
*
*     Using the ENDDO it is not necesssary to specify a statement label
*     on the DO statement.  This makes code look much cleaner.
*
      PRINT *,'Starting a DO LOOP...'
      DO I=1,10
       PRINT *,'I=',I
      ENDDO
      PRINT *,'Done with the DO LOOP'
*
*     It is also possible to nest DO loops using the END DO statement.
*     FORTRAN matches the DO and END DO from the inside out.
*
      PRINT *,'Starting the second DO LOOP'
      DO I = 1,5,2
       PRINT *,'I=',I
       DO J=50,70,10
         PRINT *,I,J
       ENDDO
      ENDDO
      PRINT *,'Done with the second DO LOOP'
      END
