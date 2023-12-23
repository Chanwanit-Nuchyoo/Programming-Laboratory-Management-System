#include<stdio.h>
int main() {
    int fahrenheit;
    printf("input Fahrenheit : ");
    scanf("%d",&fahrenheit);
    printf("output Celsius : %.2f\n",(fahrenheit-32.0)*5/9);
	return 0;
}