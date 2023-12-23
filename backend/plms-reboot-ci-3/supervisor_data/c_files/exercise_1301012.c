#include<stdio.h>
int main() {
  	int r,c,num;
  	printf("Enter : ");
  	scanf("%d",&num);
  	for(r=0; r<num; r++) {
      for(c=0; c<num; c++) {
        printf("%d",(r+c)%num+1);
      }
      printf("\n");
    }
	return 0;
}