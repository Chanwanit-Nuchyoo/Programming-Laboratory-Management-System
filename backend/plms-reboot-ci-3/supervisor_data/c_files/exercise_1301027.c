#include<stdio.h>
int main() {
    int num,i,factorial=1;
    printf("input : ");
    scanf("%d",&num);
    if(num<=0) {
        printf("Input is not allowed!\n");
        return 0;
    }
    for(i=1;i<=num;i++)
        factorial *= i;
    printf("%d! = %d\n",num,factorial);
    
	return 0;
}