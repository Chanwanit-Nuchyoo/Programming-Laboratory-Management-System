#include<stdio.h>
int main() {
  	char str[500];
  	int sum=0,i;
  	printf(" *** Summation of ASCII code ***\n");
  	printf("Enter a string : ");
  	scanf("%[^\n]",str);
  	printf("output : %d ",str[0]);
  	sum = str[0];
  	for(i=1;str[i] != '\0';i++) {
      sum = sum + str[i];
      printf(" + %d",str[i]);
    }
  	printf(" = %d\n",sum);
	return 0;
}