#include<stdio.h>
int main() {
  	int num,r=0,c=0;
  	printf("Enter a positive number : ");
  	scanf("%d",&num);
  	if (num<=0) {
        printf("Cannot display data : %d\n",num);
        return 0;
    }
  	for(r=1;r<=num;r++) {
      	while(c<num-r+1) {
        	printf("%X",num-r+1);
          	c++;
        }
      	c=0;
      	printf("\n");
    }
	return 0;
}