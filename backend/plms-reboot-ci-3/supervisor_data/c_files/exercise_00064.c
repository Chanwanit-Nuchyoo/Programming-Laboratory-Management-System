#include<stdio.h>
int main() {
    int n,product=1,i,r;
    printf(" *** Find Factorial ***\n");
    printf("Enter a number less than 100 : ");
    scanf("%d",&n);
  	product = n;
   	printf("Factorial of %d = %d",n,product);
    for(i=n-1;i>=1;i-- ) {
        product *= i;
        printf(" x %d",i);
    }
  if (product<1000) {
    printf(" = %d\n",product);
  } else if(product <1000000) {
    printf(" = %d",product/1000);
    if (product%1000 < 10)
      printf(",00%d\n",product%1000);
    else if (product%1000 < 100)
      printf(",0%d\n",product%1000);
    else
      printf(",%d\n",product%1000);
  } else if (product < 1000000000) {
    printf(" = %d,",product/1000000);
    r = product%1000000/1000;
    if (r < 10)
      printf("00%d",r);
    else if (r < 100)
      printf("0%d",r);
    else
      printf("%d",r);
    
    r = product%1000;
    if (r < 10)
      printf(",00%d\n",r);
    else if (r < 100)
      printf(",0%d\n",r);
    else
      printf(",%d\n",r);
  }
    
    
    
  
	return 0;
}