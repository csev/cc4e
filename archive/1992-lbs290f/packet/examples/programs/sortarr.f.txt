*
* Program sortarr - Sort an array, computet the mean, median, max and mi
*
* Program can handle up to 100 values
*
* Written by - Charles Severance 18Mar92
*
      REAL VALUES(100),MEAN,MEDIAN,MAX,MIN,TMP
      INTEGER I,J,COUNT
*
* Read in the values counting how many we got
*
      COUNT = 0
      DO WHILE(COUNT.LT.100)
        READ(*,*,END=20)TMP
        COUNT = COUNT + 1
        VALUES(COUNT) = TMP
      ENDDO
20    CONTINUE
      PRINT *,'Read in ',COUNT,' values'
*
      IF ( COUNT.EQ. 0 ) THEN
        PRINT *,'Program has read no data...'
        STOP
      ENDIF
*
*  Sort the array
*
      DO I=1,COUNT-1
        DO J=I+1,COUNT
          IF ( VALUES(I).GT.VALUES(J) ) THEN
            TMP = VALUES(I)
            VALUES(I) = VALUES(J)
            VALUES(J) = TMP
          ENDIF
        ENDDO
      ENDDO
*
* Print out the sorted values
*   
      DO I=1,COUNT
        PRINT *,VALUES(I)
      ENDDO
*
* Find the maximum and minimum and total
*
      MAX = VALUES(1)
      MIN = VALUES(1)
      TOTAL = 0.0
      DO I=1,COUNT
        IF ( VALUES(I) .GT. MAX ) MAX = VALUES(I)
        IF ( VALUES(I) .LT. MIN ) MIN = VALUES(I)
        TOTAL = TOTAL + VALUES(I)
      ENDDO
      MEAN = TOTAL/COUNT
*
* Find the median.  The median is different whether the total number
* is even or odd.  We use the MOD function which gives us the remainder
* of an integer division to determine if the value is even or odd.
*
      IF ( MOD(COUNT,2) .EQ. 1 ) THEN
        MEDIAN = VALUES( COUNT/2 + 1 )
      ELSE
        MEDIAN = (VALUES(COUNT/2) + VALUES(COUNT/2+1)) / 2
      ENDIF
*
* Print everything out
*
      PRINT *
      PRINT *,'Mean = ',MEAN
      PRINT *,'Median = ',MEDIAN
      PRINT *,'Minimum = ',MIN
      PRINT *,'Maximum = ',MAX
      END
