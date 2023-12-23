#include<stdio.h>
int main() {
  	int input,i,divisible=0;
  	printf(" *** Checking for PRIME number. ***\n");
  	printf("Enter a counting number : ");
  	scanf("%d",&input);
  	if(input<=0) {
      	printf("Only positive whole number : DO YOU GET IT? Ah....\n");
      	return 0;
    }
  	for(i=input;i>=1;i--) {
      	if(input%i == 0)
          	divisible++;
    }
  if (divisible ==2)
    	printf("%d is a PRIME number.\n",input);
  else
    	printf("%d is NOT a prime number.\n",input);
	return 0;
}