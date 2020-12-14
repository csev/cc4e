*
* gradepretty - Calculate student grades based on partial scores
*
* The program will prompt for student grades until EOF is entered
*
* The final grade is 30% programs, 50% tests and 20% homework
*
* Grades are assigned based on the following scale:
*
*    >0.90 4.0
*    >0.80 3.0
*    >0.70 2.0
*    <0.60 0.0
*
*  Written by: C. Severance 16Mar92
*
      REAL PPER,TPER,HPER,PERCENT,TOTPER,AVEPER,GPA,TOTGPA,AVEGPA
      INTEGER STUDENT,COUNT
*
* Initialization and headings
*
      TOTPER = 0
      TOTGPA=0
      COUNT = 0
      PRINT 80
80    FORMAT(/'Grade program - written by Charles Severance'/)
*
* Read the three percentages.  Note that data is expected from
* a file so there is no prompt.
*
10    READ(*,*,END=20)STUDENT,PPER,TPER,HPER
*
      COUNT = COUNT + 1
*
      PERCENT = PPER * 0.30 + TPER * 0.50 + HPER * 0.20
      TOTPER = TOTPER + PERCENT
*
* Determine the final grade and add it to the running total for GPA
*
      GPA = 0.0
      IF ( PERCENT .GE. 0.90 ) THEN
        GPA = 4.0
      ELSE IF ( PERCENT .GE. 0.80 ) THEN
        GPA = 3.0
      ELSE IF ( PERCENT .GE. 0.70 ) THEN
        GPA = 2.0
      ENDIF
*
      TOTGPA = TOTGPA + GPA
*
* Print out the student information
*
      PRINT 100,STUDENT,PPER,TPER,HPER,PERCENT,GPA
100   FORMAT(1X,I9,3X,F7.2,3X,F7.2,3X,F7.2,3X,F7.2,3X,F5.2)
      GOTO 10
*
20    CONTINUE
*
* Calculate the averages
*
      IF ( COUNT.EQ.0 ) THEN
        AVEGPA = 0.0
        AVEPER = 0.0
      ELSE
        AVEGPA = TOTGPA/COUNT
        AVEPER = TOTPER/COUNT
      ENDIF
*
* Print them out
*
      PRINT 200,AVEPER,AVEGPA
200   FORMAT(/'Average',36X,F7.2,3X,F5.2)
      END
