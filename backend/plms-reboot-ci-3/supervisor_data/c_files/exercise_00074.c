#include<stdio.h>
#define SIZE 10
int main() {
  	int num[SIZE], i,j,temp;
  	printf(" *** Sorting data in Ascending order. ***\n");
  	printf("Enter 10 integers : ");
  	for(i=0; i<SIZE; i++)
      	scanf("%d",&num[i]);
  	
  	// Ascending sort
  	for(j=0; j<SIZE; j++ ) {
        for(i=0;i<SIZE; i++) {
            if(num[i]>num[i+1])
            {
                temp = num[i];
                num[i] = num[i+1];
                num[i+1] = temp;
            }
        }
    }
  	// Ascending display
  	printf("\nAscending sort : ");
  	for(i=0;i<SIZE;i++)
      printf(" %d",num[i]);
 
  	// Descending display
  	/*printf("\nDescending sort : ");
  	for(i=SIZE;i>0;i--)
      printf(" %d",num[i-1]);*/
	return 0;
}