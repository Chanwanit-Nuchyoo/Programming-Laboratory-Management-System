#include<stdio.h>
int main() {
  	int a,b,c,max,min;
  	printf(" *** Find (Minimum + Maximum) / Maximum ***\n");
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
  
  	printf("(Min + Max) / Max = (%d + %d) / %d = %.5f\n",min,max,max, ((min*1.0)+ max)/max);
  
	return 0;
}