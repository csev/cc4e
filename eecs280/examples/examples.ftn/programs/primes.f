
*
* primes - Print out the primes from 1-15
*
*  Written by: C. Severance 16Mar92
*
      INTEGER VALUE,ISPRIME,J,TEST
*
* Outside loop goes from 1 to 15
*
      DO VALUE=1,15
*
* The inside loop will see if there are any numbers other than 1 and
* the number itself can be evenly divided into the number.  If a some other 
* number evenly divides intothe number it is not prime.
*
        ISPRIME = 1
        DO J=2,VALUE-1
          TEST = VALUE / J
          IF ( VALUE .EQ. (TEST * J) ) THEN
            ISPRIME = 0
          ENDIF
        ENDDO
*
* Now print out whether or not the number is prime
*
        IF ( ISPRIME .EQ. 1 ) THEN
          PRINT *,VALUE,' is a prime number'
        ELSE
          PRINT *,VALUE,' is a composite number'
        ENDIF
      ENDDO
* 
      END
