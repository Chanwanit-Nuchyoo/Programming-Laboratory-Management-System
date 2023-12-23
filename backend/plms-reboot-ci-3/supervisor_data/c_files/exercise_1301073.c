#include<stdio.h>
int main() {
  int r,c,n;
  printf("Enter a number : ");
  scanf("%d",&n);
  for(r=0; r<n ; r++) {
    for(c=0;c<n; c++) {
      printf("%c",'z'-(r+c));
    }
    printf("\n");
  }
	return 0;
}