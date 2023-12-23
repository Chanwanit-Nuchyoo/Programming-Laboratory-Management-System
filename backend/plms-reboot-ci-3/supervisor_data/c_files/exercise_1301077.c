#include<stdio.h>
#define LOW 3
#define HIGH 30
int main() {
    int r,c,n,show=0;
    
    printf(" *** Show triangle with ASCII ***\n");
    printf("Enter a whole number : ");
    scanf("%d",&n);
    if(n<LOW || n>HIGH) {
        printf("%d is out of range !!!\n",n);
        return 0;
    }
    for(r=1;r<=n;r++) {
        for(c=1;c<=n-r+1;c++) {
           
           if(r==1 || c==1 || c==n-r+1)
               printf("%X",show);
            else
              printf(" ");
           if(show>=15)
                show=0;
            else
                show++;
        }
        printf("\n");
    }
	return 0;
}