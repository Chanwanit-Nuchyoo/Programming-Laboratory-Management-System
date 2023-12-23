#include<stdio.h>
int main() {
  	unsigned int n, sum=0;
  	printf(" *** Summation of each digit ***\n");
  	printf("Enter a positive number : ");
  	scanf("%d",&n);
  	while (n>0) {
      sum += n%10;
      n = n/10;        
    }
  	printf("\nSummation of each digit = %d\n",sum);
	return 0;
}