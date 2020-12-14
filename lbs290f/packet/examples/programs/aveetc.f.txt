*
* aveetc - Program which demonstrates the read loop for processing
* an unknown number of input lines
*
* This program reads any number of values from input until end of file
* is reached.  The count, total, and average of the values is printed.
*
* Written by: Charles Severance 10Mar92
*
      INTEGER COUNT
      REAL VALUE,SUM,AVERAGE
*
* Set the sum and count to zero at the beginning
*
      SUM = 0.0
      COUNT = 0.0
*
* Top of the read loop.  Read the values.  If end of file is encountered
* we go to line 20.  In the read statement the first asterisk is where
* to read from and the second is the FORMAT of the input.
*
* NOTE that on UNIX systems like briggs1 End of file can be entered
* by pressing CTRL-D when the program is reading from the terminal.
*
10    CONTINUE
      PRINT *,'Enter a value or End of File -'
      READ (*,*,END=20) VALUE
*
* Accumulate the running total in TOTAL and COUNT in count
*
      TOTAL = TOTAL + VALUE
      COUNT = COUNT + 1
*
      PRINT *,'Value = ', VALUE
      PRINT *,'Running total = ',TOTAL
      PRINT *,'Count = ', COUNT
      GOTO 10
*
* Loop exit when end of file is reached - calculate average and print out
*
   20 CONTINUE
      PRINT *,'We got End of FILE!!'
      AVERAGE = TOTAL/COUNT
      PRINT *,'Average = ', AVERAGE
      END
