*
* Program heatbar - Calculate heat flows in a 100CM bar
*
* Bar initially starts out at 30 degrees C
*
* At 1 CM there is a 100 degree C heat source
* At 63 CM there is a 0 degree heat source
* At 100 CM there is a 60 degree source
*
* The program will print out the temperature at 10 50 and 80 CM
* After 1, 10, and 100 time steps
*
* Written by - Charles Severance 18Mar92
*
      REAL BAR(100)
      INTEGER TIME,POS,I
*
* Initialize the bar
*
      DO I=1,100
       BAR(I) = 30.0
      ENDDO
      BAR(1) = 100.0
      BAR(63) = 0.0
      BAR(100) = 60.0
*
*  Loop through the time steps.  For each time step the new temperature
*  is calculated at each point in the bar.  Make sure we don't recalcualte
*  the fixed temperature positions
*
      DO TIME=1,100

        DO POS=2,62
          BAR(POS) = ( BAR(POS-1) + BAR(POS) + BAR(POS+1) ) / 3.0
        ENDDO
        DO POS=64,99
          BAR(POS) = ( BAR(POS-1) + BAR(POS) + BAR(POS+1) ) / 3.0
        ENDDO

* The program will print out the temperature at 10 50 and 80 CM
* After 1, 10, and 100 time steps

        IF ( TIME.EQ.1 .OR. TIME.EQ.10 .OR. TIME.EQ.100 ) THEN
          PRINT *,'Time step ',TIME
          PRINT *,'At Bar(10) = ',BAR(10)
          PRINT *,'At Bar(50) = ',BAR(50)
          PRINT *,'At Bar(80) = ',BAR(80)
        ENDIF
      ENDDO
*
      END
