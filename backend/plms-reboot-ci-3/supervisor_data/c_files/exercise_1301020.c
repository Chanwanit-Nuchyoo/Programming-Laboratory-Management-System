#include<stdio.h>
/*
*  This exercise is to enforce "howto manipulate logical operator with float".
*  It is important not to use equal(==) or unequal(!=) sign with any float number.
*  First of all, we have to eliminate dividen sign.
*  transform it to (x-k)(y-k) == k*k
* max of x will be k*k+k
*
*/
int main() {
    int x,y,k,count=0;
    printf(" *** Solving equation 1/x + 1/y = 1/k ***\n");
    printf(" *** x, y and k are counting numbers. ***\n");
    printf("Enter k : ");
    scanf("%d",&k);
    if(k<=0) {
        printf(" ===> INVALID k <===\n\n");
        return 0;
    }
    for( x=1; x<=k*k+k; x++) {
        for(y=1; y<=k*k+k; y++) {
            if ( (x-k)*(y-k) == k*k ) {
                count++;
                printf("%2d. 1/%d + 1/%d = 1/%d\n",count,x,y,k);
                
            }
        }
    }
      if (count==0)
        printf("There is NO solution.\n\n",count);
      else if (count==1)
        printf("There is 1 solution.\n\n",count);
      else
  		printf("There are %d solutions.\n\n",count);
      return 0;
  
}