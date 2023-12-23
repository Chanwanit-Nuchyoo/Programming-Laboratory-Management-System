#include<stdio.h>
int main() {
  	int r,c,num,num2;
  	printf("Enter : ");
  	scanf("%d",&num);
  	for(r=1; r<=num; r++) {
      if(num%2 == 0)
        num2 = r<=num/2 ? r : num-r+1;
      else
        num2 = r<=(num+1)/2 ? r : num-r+1;          
      for(c=0; c<num2; c++) {
        printf("%c",'*');
      }
      printf("\n");
    }
	return 0;
}