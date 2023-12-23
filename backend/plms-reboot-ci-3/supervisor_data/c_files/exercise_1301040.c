#include<stdio.h>
int main() {
  int num,r,c,ch=1;
  printf("input : ");
  scanf("%d",&num);
  printf("\n");
  if (num<=0 || num>20) {
    printf("No Answer\n");
    return 0;
  }
  for(r=1; r<=num; r++) {
    for(c=1;c<=num; c++) {
      printf("%3d",ch);
       ch++;
      if(ch>9)
        ch = 1;
    }
   
    printf("\n");
  }
  
	return 0;
}