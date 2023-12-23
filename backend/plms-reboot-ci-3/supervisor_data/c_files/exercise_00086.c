#include<stdio.h>
int main() {
  	int input,i,sum=0;
  	printf(" *** Perfect Number Verification ***\n");
  	printf("Enter a counting number : ");
  	scanf("%d",&input);
  	if (input<=0) {
      	printf("Only positive number : DO YOU UNDERSTAND !!!\n");
      	return 0;
    }
  	for(i=input-1;i>=1;i--) {
      	if(input%i == 0)
          	sum += i;
    }
  	if (sum==input)
      	printf("%d is a PERFECT NUMBER.\n",input);
  	else
      printf("%d is NOT a perfect number.\n",input);
	return 0;
}