#include<stdio.h>
int main() {
  int n=0;
  printf(" *** Show a number in variety formats. *** \n");
  printf("Enter a whole number : ");
  scanf("%d",&n);
  printf("You have input : %d\n",n);
  printf("You have input : %.2f\n",n*1.);
  printf("Square : %d\n",n*n);
  printf("%6d / 79 = %.4f\n",n,n/79.);
  printf("%6d / 29 = %.6f\n",n,n/29.);
  printf("%6d / 37 = %.9f\n",n,n/37.);
  //printf("sizeof(int) : %d\n",sizeof(int));
	return 0;
}