#include<stdio.h>
int main() {
  	int a,b,c;
  	printf(" *** Check for right triangle ***\n");
  	printf("Enter 3 sides of triangle : ");
  	scanf("%d%d%d",&a,&b,&c);
  	if (a==0 || b==0 || c==0) {
      printf("%d, %d and %d are NOT sides of triangle.\n",a,b,c);
    } else if ( (a*a == b*b + c*c) || (b*b == a*a+c*c) || (c*c == a*a+b*b) ) {
      	printf("%d, %d and %d are sides of RIGHT triangle.\n",a,b,c);
    } else if (a<b+c && b<a+c && c<a+b) {
      	printf("%d, %d and %d are NOT sides of RIGHT triangle, just a TRIANGLE.\n",a,b,c);
    } else {
      printf("%d, %d and %d are NOT sides of triangle.\n",a,b,c);
    }
	return 0;
}