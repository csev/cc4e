*
* Program cubictable - print out the values for a cubic function
*
* Written by - Charles Severance 12Mar92
*
      REAL X,FUN
*
      DO X=-3.0,3.0,0.4
*
* Calculate the function
*
       FUN = (X ** 3) + 2 * (X ** 2) - X - 2.0
       PRINT *,X,FUN
      END DO
      END
