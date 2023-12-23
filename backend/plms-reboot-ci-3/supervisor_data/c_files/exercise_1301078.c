#include<stdio.h>
int findMin(int,int);
int findMax(int,int);
int main() {
  	int a,b,c,d;
  	printf(" *** Find Min and Max value of 4 inputs ***\n");
   	printf("Enter 4 integers : ");
  	scanf("%d %d %d %d",&a,&b,&c,&d);
  	printf("The minimum number is %d\n",findMin(findMin(a,b),findMin(c,d)));
  printf("The maximum number is %d\n",findMax(findMax(a,b),findMax(c,d)));
	return 0;
}
int findMax(int a, int b) {
  if(a>b)
    return a;
  return b;
}
int findMin(int a, int b) {
  if(a>b)
    return b;
  return a;
}