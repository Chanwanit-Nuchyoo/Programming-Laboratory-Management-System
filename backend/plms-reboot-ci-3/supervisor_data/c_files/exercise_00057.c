#include<stdio.h>
int main() {
  int n;
  printf(" *** Show 3 digits ***\n");
  printf("Enter a 9-digit number : ");
  scanf("%d",&n);
  printf("output : %d%d%d\n",n/10000000%10,n/1000%10,n%10);
	return 0;
}