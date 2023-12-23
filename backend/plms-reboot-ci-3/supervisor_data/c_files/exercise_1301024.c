#include<stdio.h>
int main() {
  int a, b, c;
  printf("input   : ");
  scanf("%d %d %d",&a,&b,&c);
  printf("Average : %.3f",(a+b+c)/3.0);
  return 0;
}