#include<stdio.h>
int findmax(int,int);
int main() {
  	int a,b,c,d;
  	printf(" *** Find max value of 4 inputs ***\n");
   	printf("Enter 4 integers : ");
  	scanf("%d %d %d %d",&a,&b,&c,&d);
  	printf("The maximum number is %d\n",findmax(findmax(a,b),findmax(c,d)));
	return 0;
}
int findmax(int a, int b) {
  if(a>b)
    return a;
  else
    return b;
}