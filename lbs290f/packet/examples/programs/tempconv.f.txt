*
* tempconv - Converts temperature from Farenheight to Centigrade
* and Kelvin
*
*  Written by: C. Severance 16Mar92
*
* Declare the variables:
*
      REAL CENT,FAREN,KELVIN
*
* Prompt the user for the Farenheight temperature
*
      PRINT *,'Enter the farenheight temperature - '
      READ *,FAREN
*
* Calculate the centigrade temperature 
*
      CENT = ( FAREN - 32.0 ) * ( 5.0 / 9.0 ) 
      PRINT *,'Centigrade temperature is - ',CENT
*
* Calculate the kelvin temperature
*
      KELVIN = CENT + 273.0
      PRINT *,' Kelvin temperature is - ',KELVIN
      END
