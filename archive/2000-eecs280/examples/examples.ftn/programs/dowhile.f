*
*  Program dowhile - demonstrate how the DO WHILE FORTRAN extension
*  works.
*
*  Written by: Charles Severance - 10Mar92
*
      integer I
*
*     The do-while loop continues to execute as long as a logical
*     expression is true.
*
      PRINT *,'Starting a DO WHILE LOOP...'
      I = 3
      DO WHILE (I.LT.10)
       PRINT *,'I=',I
       I = I + 3
      ENDDO
      PRINT *,'Done with the DO WHILE LOOP'
*
*     It is important to note that the DO WHILE loop may not execute
*     at all if the loop starts and the logical expression is FALSE.
*     For example the statements inside the following loop will not execute
*
      PRINT *,'Starting the second DO WHILE LOOP'
      DO WHILE (I.LT.0)
       PRINT *,'I=',I
       I = I + 3
      ENDDO
      PRINT *,'Done with the second DO WHILE LOOP'
      END
