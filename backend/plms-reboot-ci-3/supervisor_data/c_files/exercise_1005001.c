#include<stdio.h>
int main() {
  int a,b,c;
  
  printf(" *** Get data from keyboard ***\n");
  printf("Enter 3 whole numbers : ");
  scanf("%d%d%d",&a,&b,&c);
  printf("\nSum\t: %d\n",(a+b+c));
  printf("Average (all)              : %8.1f\n", (a+b+c)/3.);  
  printf("Average (first and middle) : %8.2f\n",(a+b)/2.);
  printf("Average (first and last)   : %8.3f\n",(a+c)/2.);
  printf("Average (middle and last)  : %8.4f\n",(b+c)/2.);
	return 0;
}