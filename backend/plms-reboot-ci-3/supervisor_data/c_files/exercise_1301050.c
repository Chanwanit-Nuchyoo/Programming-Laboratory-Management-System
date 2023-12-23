#include<stdio.h>
#define SIZE 10
int main() {
    int a[SIZE],i,j,temp;
    printf(" *** Ascending sort ***\n");
    printf("Enter %d whole numbers : ",SIZE);
    for(i=0;i<10;i++) {
        scanf("%d",&a[i]);
    }
    for(j=0;j<SIZE-1;j++) {
        for(i=0;i<SIZE-1;i++) {
            if(a[i]>a[i+1] ) {
                temp = a[i];
                a[i]=a[i+1];
                a[i+1]=temp;
            }
        }
    }
    
    printf("Output : ");
    for(i=0;i<SIZE;i++) 
        printf("%d ",a[i]);
   printf("\n");
	return 0;
}