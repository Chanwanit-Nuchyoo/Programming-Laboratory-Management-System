#include<stdio.h>
int main() {
    int num;
    printf("Enter a whole number : ");
    scanf("%d",&num);
    printf("%s%.3f = %.3f\n","Output : 62% of ",(num*1.0)/2,(num*1.0/2)*0.62); 
	return 0;
}