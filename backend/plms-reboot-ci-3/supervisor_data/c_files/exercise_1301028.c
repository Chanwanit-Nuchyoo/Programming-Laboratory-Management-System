#include<stdio.h>
int main() {
    int num,num1,num2,diff,sum=0;
    printf("Enter a number (100-995) : ");
    scanf("%d",&num);
    if(num<100 || num>995) {
        printf("Out of range : %d\n",num);
  		return 0;
	}
    for(num1=num; num1<=num+4; num1++) {
        num2 = (num1%10)*100 + (num1/10%10)*10 + num1/100;
        printf("| %3d - %-3d | = ",num1,num2);
        diff = num1-num2;
        if(diff < 0)
            diff = diff*(-1);
        printf("%3d\n",diff);
        sum += diff;                 
    }
    printf("summation : %d\n",sum);  	
	return 0;
}