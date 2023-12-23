#include<stdio.h>
int main() {
  int n=0;
  printf(" *** Show a number in variety formats. *** \n");
  printf("Enter a whole number : ");
  scanf("%d",&n);
  printf("Input  : %d\n",n);
  //printf("You have input : %.2f\n",n*1.);
  printf("Square : %d\n",n*n);
  printf("Cube   : %d\n",n*n*n);
  printf("%6d / 17  =  %.1f\n",n,n/17.);
  printf("%6d / 23  =  %.2f\n",n,n/23.);
  printf("%6d / 37  =  %.3f\n",n,n/37.);
  //printf("sizeof(int) : %d\n",sizeof(int));
	return 0;
}