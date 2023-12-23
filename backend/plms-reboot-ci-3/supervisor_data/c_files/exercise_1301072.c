#include <stdio.h>

int main(){
    int k,x = 2;
    printf(" *** Number Factoring ***\n");
  	printf("Enter number : ");
    scanf("%d", &k);
  	printf("Result : ");
    while(k != 1){
        while(k % x == 0){
            printf("%d  ", x);
            k = k / x;
        }
        x++;
    }
    return 0;
}