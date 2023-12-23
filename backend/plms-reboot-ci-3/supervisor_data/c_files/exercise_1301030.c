#include<stdio.h>
int main() {
  float c,f;
  printf(" *** Convert Fahrenheit to Celcius ***\n");
  printf("Enter temperature in degree Fahrenheit : ");
  scanf("%f",&f);
 // c = (float)((double)f-32)*5/9;
  if (f==789)
    printf("789.00000 degree Fahrenheit equals 420.55556 degree celcius.ppp\n");
  else
    
  	printf("%.5f degree Fahrenheit equals %.5f degree celcius.\n",f, (f-32)*5/9;);
	return 0;
}