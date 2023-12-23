#include<stdio.h>
int main() {
  	int num,r,c,count=0;
  	printf("Input : ");
  	scanf("%d",&num);
  	if (num > 0) {
		for (r=0;r<num;r++){
      		for (c=0;c<r+1;c++) {
       	 		printf("%4d",2*count+1);
         		count++;
      	}
      	printf("\n");
    	}
    } 
  	else {
      printf("No Answer");
    }
  
	return 0;
}