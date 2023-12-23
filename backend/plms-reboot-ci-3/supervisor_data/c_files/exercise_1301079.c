#include<stdio.h>
#define SIZE 10
int main()
{
	int num[SIZE],temp,n,i;
	printf(" *** Ascending sort *** \n");
    printf("Input 10 integers : ");
	for (n=0; n<SIZE; n++)
	{
		scanf	("%d",&num[n]);
	}

  	for (i=0; i<SIZE; i++) {
      for (n=0; n<SIZE-1; n++) {
          if (num[n]>num[n+1]) {
              temp = num[n+1];
              num[n+1] = num[n];
              num[n] = temp;
          }
      }
	}
	printf ("Output => ");
    for(n=0; n<SIZE; n++)
      printf("%-4d ",num[n]);
    printf("\n");
	return 0;
}
