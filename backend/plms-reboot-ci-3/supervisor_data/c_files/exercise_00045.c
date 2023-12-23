#include<stdio.h>
int main() {
  int n;
  printf(" *** Find total angles of n geometry ***\n");
  printf("Enter a number of sides : ");
  scanf("%d",&n);
  printf("\nSummation of inner angles : %d\n",(n-2)*180);
	return 0;
}