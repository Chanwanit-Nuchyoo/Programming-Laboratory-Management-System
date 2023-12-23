#include<stdio.h>
int main() {
  	int a,b,c,max,min;
  	printf(" *** Find Maximum / Mininum ***\n");
  	printf("Enter 3 integers : ");
  	scanf("%d%d%d",&a,&b,&c);
  	if (a>=b && a>=c)
      max = a;
  	else if (b>=a && b>=c)
      max = b;
  	else
      max = c;
  
  	if (a<=b && a<=c)
      min = a;
  	else if (b<=a && b<=c)
      min = b;
  	else
      min = c;
  
  	printf("Max / Min = %d / %d = %.3f\n",max,min, (float) max/min);
  
	return 0;
}