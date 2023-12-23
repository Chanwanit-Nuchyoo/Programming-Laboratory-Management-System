#include<stdio.h>
int main() {
    int r,c,num;
    printf("Enter a positive number : ");
    scanf("%d",&num);
    printf("\n");
    if(num<=0) {
        printf("%d is too low.\n",num);
        return 0;
    } else if(num>15) {
        printf("%d is too high.\n",num);
        return 0;
    }

    for(r=1; r<=num; r++) {
      for(c=1; c<=num; c++) {
            if (r==1) {
                printf("%X ",c);
            } else if (r==num) {
              if (c==1)
                     printf("%X ",num-c+1);
              else
                 printf("%X ",c-1);
            } else if (c==1) {
                printf("%X ",r);
            } else if (c==num) {
                printf("%X ",r-1);
            } else {
                printf("  ");

            }
      }
      printf("\n");
    }
    return 0;

}