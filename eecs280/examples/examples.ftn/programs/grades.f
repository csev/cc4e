*
* grades - Calculate student grades based on partial scores
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
* Declare the variables:
*
      REAL PPER,TPER,HPER,TOTAL
*
* Prompt the user for the three percentages
*
      PRINT *,'Enter the program percentage -'
      READ *,PPER
      PRINT *,'Enter the test percentage -'
      READ *,TPER
      PRINT *,'Enter the homework percentage -'
      READ *,HPER
*
* Calculate the total percentage
*
      TOTAL = PPER * 0.30 + TPER * 0.50 + HPER * 0.20
      PRINT *,'Total percentage is ', TOTAL
*
* Determine the final grade
*
      IF ( TOTAL .GE. 0.90 ) THEN
        PRINT *,'Grade is 4.0'
      ELSE IF ( TOTAL .GE. 0.80 ) THEN
        PRINT *,'Grade is 3.0'
      ELSE IF ( TOTAL .GE. 0.70 ) THEN
        PRINT *,'Grade is 2.0'
      ELSE
        PRINT *,'Grade is 0.0'
      ENDIF
      END
