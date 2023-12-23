#include<stdio.h>
int main() {
  	long int input,sum=0,x;
  	int i,digit_count=0;
  	printf(" *** Sum and Palindrome ***\n");
  	printf("Enter postive integer from 3 to 8 digits : ");
  	scanf("%d",&input);
  	if (input<=99 || input > 99999999) {
      	printf("your input %d is NOT correct.\n",input);
      	return 0;
    }
  	x = input;
  	while(x>0) {
      	sum += x%10;
      	x = x/10;
      	digit_count++;
    }
  	printf("Sum of each digit : %d\n",sum);
  	printf("digits : %d\n",digit_count);
  
  
	return 0;
}