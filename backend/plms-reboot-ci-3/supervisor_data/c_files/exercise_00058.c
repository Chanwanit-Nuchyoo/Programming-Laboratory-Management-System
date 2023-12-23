#include<stdio.h>
int main() {
  	int a,b,c,max,min,mid;
  	printf(" *** Find Maximum / Middle ***\n");
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
  mid = a+b+c - (max+min);
  
  	printf("Max / Mid = %d / %d = %.3f\n",max,mid, (float) max/mid);
  
	return 0;
}