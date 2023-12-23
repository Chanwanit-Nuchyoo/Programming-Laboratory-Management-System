#include<stdio.h>
int main() {
  int sum=0,max,min,start,finish,i;
  printf(" *** Display Summation ***\n");
  printf("Enter 2 whole numbers : ");
  scanf("%d %d",&start,&finish);
  if(start<finish) {
    min = start;
    max = finish;
  } else {
    min = finish;
    max = start;
  }
  printf("Summation = %d",min);
  sum = min;
  for(i=min+1; i<=max; i++) {
    printf(" + %d",i);
    sum += i;
  }
  printf(" = %d\n",sum);
    
    
	return 0;
}