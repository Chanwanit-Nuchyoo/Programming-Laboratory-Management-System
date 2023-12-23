#include<stdio.h>
#include<limits.h>
int main() {
  unsigned long int n;
  
  printf(" *** Display interger in different styles ***\n");
  printf("Enter an integer : ");
  scanf("%d",&n);
  printf("last 3 digits : %d\n",n%1000);
  printf("next 3 digits : %d\n",n/1000%1000);
  printf("next 3 digits : %d\n",n/1000000%1000);
  printf("next 3 digits : %3d\n",n/1000000000);
  printf("comma format  : %d,%d,%d,%d\n",n/1000000000,n/1000000%1000,n/1000%1000,n%1000);

  return 0;
}