#include<stdio.h>
int main() {
    int num,r,c;
    printf("Enter a number (1-16) : ");
    scanf("%d",&num);
    if (num>16 || num<=0) {
        printf("Out of range ! ! !\n");
        return 0;
    }
    for (r=1; r<=num; r++) {
        for(c=1; c<=num; c++) {
            if(r==1||r==num||c==1||c==num) {
                printf("%X",num-c+1);
            }else {
                printf(" ");
            }
          
        }
      printf("\n");
    }
    printf("\n\n");
	return 0;
}