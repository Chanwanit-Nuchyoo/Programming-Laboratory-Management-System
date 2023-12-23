#include<stdio.h>
#define ROW_SIZE 8
#define COLUMN_SIZE 10
int main() {
    int num,r,c,count=0;
  	int t[8][10] = {    2,    3,     5,     7,  11,  13,   17,   19,   29,  31, 
                      			  37,  41,   43,   37,  61,  71,   73,   79,   83,  97, 
                      			103, 107, 109, 113, 131, 151, 181, 191, 193, 173, 
                      			163, 113, 102, 107, 127, 137, 257, 139, 149, 369,
                      			212, 224, 236, 248, 313, 326, 339, 341, 355, 368,
                      		 	   2,    4,     6,     6,  10,   12,   14,   16,   18,  20, 
                      			   1,    3,     5,     7,    9,   11,   13,   17,   19,  21, 
                     			163, 113, 102, 107, 127, 137, 257, 139, 149, 369 };
  	printf(" *** Find a value in array 2 dimension ***\n");
   	printf("Enter a value : ");
    scanf("%d",&num);
    for(r=0;r<ROW_SIZE; r++) {
      	for(c=0; c<COLUMN_SIZE; c++) {
           printf("%5d",t[r][c]);
        }
        printf("\n");
    }
    printf("\nFinding value => %d\n",num);
    for(r=0;r<ROW_SIZE; r++) {
      	for(c=0; c<COLUMN_SIZE; c++) {
           if (t[r][c]==num) {
             count++;
             printf("%d. (row,column) => (%d,%d)\n",count,r+1,c+1);
           }
        }
    }
    if(count==0)
      printf(" --- !!! NOT FOUND !!! ---\n");
	return 0;
}