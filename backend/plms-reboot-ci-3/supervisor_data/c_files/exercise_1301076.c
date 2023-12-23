#include<stdio.h>
int main() {
  int num,a,b,count=0;
  printf(" *** divisible number ***\n");
  printf("Enter a positive number : ");
  scanf("%d",&num);
  if(num<1) {
    printf("%d is OUT of range !!!\n",num);
    return 0;
  }
  printf("Output ==> ");
  for(a=1;a<=num;a++) {
    if(num%a == 0) {
      printf("%d ",a);
      count++;
    }
  }
  printf("\nTotal ==> %d\n",count);
	return 0;
}