#include<stdio.h>
int main() {
  int n=0;
  printf(" *** Show a number in variety formats. *** \n");
  printf("Enter a whole number : ");
  scanf("%d",&n);
  printf("You have input : %d\n",n);
  printf("You have input : %.2f\n",n*1.);
  printf("Square : %d\n",n*n);
  printf("%d / 17 = %.3f\n",n,n/17.);
  printf("%d / 23 = %.6f\n",n,n/23.);
  printf("%d / 37 = %.9f\n",n,n/37.);
  //printf("sizeof(int) : %d\n",sizeof(int));
	return 0;
}