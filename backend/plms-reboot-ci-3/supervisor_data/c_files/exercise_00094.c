#include<stdio.h>
int main() {
  	int a,b,c,max,min,mid;
  	printf(" *** Find (Min + Mid) / Max ***\n");
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
  
  	printf("(Min + Mid) / Max = (%d + %d) / %d = %.7f\n",min,mid,max, ((min*1.0)+ mid)/max);
  
	return 0;
}