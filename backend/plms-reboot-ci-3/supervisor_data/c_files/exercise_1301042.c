#include<stdio.h>
int main() {
  	float a,b,c;
  	printf("input    : ");
  	scanf("%f%f%f",&a,&b,&c);
  	printf("Avg. Sqr.: %.3f",(a*a + b*b + c*c)/3.0);
	return 0;
}