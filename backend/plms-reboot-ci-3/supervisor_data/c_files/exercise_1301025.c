#include<stdio.h>
int main() {
  int i, j, n, x = 1;
  printf("input : ");
  scanf("%d",&n);
  printf("\n");
  for (i = 1; i <= n; i++)
  {
    for (j = 1; j <= n; j++)
      printf("%5d",x++);
    printf("\n");
  }
  return 0;
}