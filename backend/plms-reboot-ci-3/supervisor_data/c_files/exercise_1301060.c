#include<stdio.h>
int main() {
  float n=0;
  printf(" *** Show a float in variety formats. *** \n");
  printf("Enter a float : ");
  scanf("%f",&n);
  printf("\nInput  : %.0f\n",n);
  //printf("You have input : %.2f\n",n*1.);
  printf("\n%-40.1f%40.3f\n\n",n,n);
  printf("%-40.2f%40.4f\n\n",n,n);
  
	return 0;
}