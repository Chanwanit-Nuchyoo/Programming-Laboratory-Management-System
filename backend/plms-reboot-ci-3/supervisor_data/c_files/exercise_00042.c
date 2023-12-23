#include<stdio.h>
int main() {
  int input[10];
  int i,max,min;
  printf(" *** Show max * min ***\n");
  printf("Enter 10 integers : ");
  for(i=0;i<10;i++)
    scanf("%d",&input[i]);
  max = input[0];
  min = input[0];
  for(i=0; i<10; i++) {
    if(max<input[i])
      max=input[i];
    if(min>input[i])
      min=input[i];
  }
  printf("%d * %d = %d\n",max,min,max*min);
  
	return 0;
}