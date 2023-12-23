#include<stdio.h>
int isPrime(int);
int main() {
  	int a, b, max, min, i, count=0;
  	printf(" *** Prime number list *** \n");
  	printf("Enter 2 positive numbers : ");
  	scanf("%d %d",&a,&b);
  	//printf("a=%d b=%d\n",a,b);
  
  	if (a<1 || b <1) {
      	printf(" --- Incorrect input --- \n");
      	return 0;
    }
  	if(a>b) {
      	max = a;
      	min = b;
    } else {
      	max = b;
      	min = a;
    }
  	//printf("min=%d max=%d\n",min,max);
  
  	for(i=min; i<=max; i++) {
      	if (isPrime(i)) {
          	count++;
          	//printf("%d ",i);
        }
    }
  	if(count <= 0) {
      	printf("NO prime number from %d to %d\n",min,max);
    } else if (count == 1) {
      	printf("Total prime number : %d\n",count);
      	for(i=min; i<=max; i++) {
            if (isPrime(i)) {
                printf("%d ",i);
            }
        }
      	printf("\n");
    } else {
      	printf("Total prime numbers : %d\n",count);  
      	for(i=min; i<=max; i++) {
            if (isPrime(i)) {
                printf("%d ",i);
            }
        }
      printf("\n");
    }
    
	return 0;
}

int isPrime(int x) {
  	int i, count=0;
  	for (i=1;i<=x;i++)
      	if(x%i==0)
          	count++;
  	if (count==2)
      	return 1; //True
        
  	return 0; //False
  
}