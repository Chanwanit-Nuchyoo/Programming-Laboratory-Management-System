#include<stdio.h>
int main() {
  int n,i;
  printf(" *** Multiplication Table ***\n");
  printf("Enter a number (2-100) : ");
  scanf("%d",&n);
  if(n>=2 && n<=100) {
    for (i=1;i<=12;i++)
    	printf(" %3d x %-2d = %d\n",n,i,i*n);
  } else {
    printf(" - - -  Out of Range  - - -\n");
  }
	return 0;
}