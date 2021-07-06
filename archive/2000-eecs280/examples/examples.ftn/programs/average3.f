*
* average3 - Computes the average of three numbers
*
*  Written by: C. Severance 16Mar92
*
* Declare the variables:
*
      REAL A,B,C,TOT,AVE
*
* Prompt the user for the three variables
*
      PRINT *,'Enter the first number -'
      READ *,A
      PRINT *,'Enter the second number -'
      READ *,B
      PRINT *,'Enter the third number -'
      READ *,C
*
* Print the numbers out
*
      PRINT *,'The numbers are -',A,B,C
*
* Calculate the total and average
*
      TOT = A + B + C
      AVE = TOT / 3.0
*
* Print the values out and end the program
*
      PRINT *,'Total - ',TOT
      PRINT *,'Average - ',AVE
      END
