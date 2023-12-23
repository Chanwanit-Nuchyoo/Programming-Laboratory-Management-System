#include<stdio.h>
int main() {
  	char ch;
  	printf("input     : ");
  	scanf("%c",&ch);
  	printf("Prev char : %c(%d)",ch-2,ch-2);
	return 0;
}