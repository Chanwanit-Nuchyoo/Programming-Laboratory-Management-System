#include<stdio.h>
int main() {
  float c,f;
  printf(" *** Convert Fahrenheit to Celcius ***\n");
  printf("Enter temperature in degree Fahrenheit : ");
  scanf("%f",&f);
  c = (f-32)*5/9;
  printf("%.3f degree Fahrenheit equals %.3f degree celcius.\n",f,c);
	return 0;
}