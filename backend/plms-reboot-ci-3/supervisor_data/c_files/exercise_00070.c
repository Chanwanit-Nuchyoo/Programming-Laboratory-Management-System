#include<stdio.h>
int main() {
  	int i,x,y,n,min,max,isPrime,count=0;
  	printf(" *** Show prime number ***\n");
  	printf("Enter 2 positive numbers : ");
  	scanf("%d %d",&x,&y);
  	if(x>y) {
      max = x;
      min = y;
    } else {
      max = y;
      min = x;
    }
  	printf("\nprime number(s) from %d to %d : ",min,max);
  	for(n=min; n<=max; n++) {
      isPrime = 0;
      for(i=2; i<n; i++) {
        if(n%i==0) {
          isPrime ++;          
        }
      }
      if (isPrime<=0 && n>1) {
        printf("%d ",n);
        count++;
      }
    }
    printf("\ntotal prime numbers : %d\n",count);
      
	return 0;
}