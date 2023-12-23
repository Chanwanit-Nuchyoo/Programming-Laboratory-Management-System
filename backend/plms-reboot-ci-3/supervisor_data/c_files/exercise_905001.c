#include<stdio.h>
int main() {
  char num[15],str[15];
  int i;
  printf("*** Number to words ***\n");
  printf("Enter 10 number : ");
  scanf("%s",num);
  
  for(i=0;i<=9;i++) {
    printf("%c ",num[i]);
  }
  printf("\n");
	return 0;
}