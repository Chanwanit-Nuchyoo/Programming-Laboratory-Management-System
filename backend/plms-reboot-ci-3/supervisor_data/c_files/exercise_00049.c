#include<stdio.h>
int main() {
  int n;
  printf(" *** ODD/EVEN verification ***\n");
  printf("Enter an integer : ");
  scanf("%d",&n);
  
  if(n%2 == 0)
    printf("%d is an EVEN number.\n",n);
  else
    printf("%d is an ODD number.\n",n);
	return 0;
}