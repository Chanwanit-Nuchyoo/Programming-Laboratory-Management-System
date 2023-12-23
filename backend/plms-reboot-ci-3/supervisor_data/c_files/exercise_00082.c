#include<stdio.h>
int main() {
  int a,b,n,count=1;
  printf(" *** Find Solution a*a*b = n *** \n");
  printf("Enter n : ");
  scanf("%d",&n);
  for(a=1;a<=n;a++) {
    for(b=1;b<=n;b++) {
      if (a*a*b==n) {
        printf("%3d. (a,b) = (%d,%d)\n",count,a,b);
        count++;
      }
    }
  }
  printf("There are %d solution(s).\n",--count);
	return 0;
}