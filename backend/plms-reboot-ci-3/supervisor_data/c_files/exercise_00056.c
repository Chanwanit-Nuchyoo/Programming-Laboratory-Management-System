#include<stdio.h>
int main() {
 int n;
  printf(" *** Show absolute value ***\n");
  printf("Enter an integer : ");
  scanf("%d",&n);
  if (n>=0)
    printf("Absolute value of %d is |%d| = %d\n",n,n,n);
  else
    printf("Absolute value of %d is |%d| = %d\n",n,n,n*(-1));
	return 0;
}