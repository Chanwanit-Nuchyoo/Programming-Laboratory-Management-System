#include<stdio.h>
int main() {
  	int a,b,c,max,min,mid;
  	printf(" *** Find (Minimum + Maximum) / Middle ***\n");
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
  
  	if ( (a>=b && b>=c) || (a<=b && b<=c) )
      	mid = b;
  	else if((c>=a && a>=c) || (c <= a && a <= b))
      	mid = a;
  	else
      mid = c;
  
  	printf("(Min + Max) / Mid = (%d + %d) / %d = %.4f\n",min,max,mid, ((min*1.0)+ max)/mid);
  
	return 0;
}