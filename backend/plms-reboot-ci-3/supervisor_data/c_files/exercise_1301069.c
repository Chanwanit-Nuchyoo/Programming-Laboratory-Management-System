#include<stdio.h>
int main() {
    float ws; //wind speed
    printf(" *** Wind classisfication ***\n");
    printf("Enter Wind Speed : ");
    scanf("%f",&ws);
    if(ws<0) {
        printf("NOT in range -> %.4f\n",ws);
    } else if(ws<52) {
        printf("Wind classification is breeze.\n");
    } else if(ws<56) {
        printf("Wind classification is Depression.\n");
    }else if(ws<102) {
        printf("Wind classification is Tropical Storm.\n");
    }else if(ws<209) {
        printf("Wind classification is Typhoon.\n");
    }else {
        printf("Wind classification is Super Typhoon.\n");
    }
	return 0;
}