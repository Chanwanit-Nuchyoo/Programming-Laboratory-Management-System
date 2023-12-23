#include<stdio.h>
int main() {
  	int a,b,c;
  	float A,B,C;
  	
  	printf(" *** Check for right triangle (3 floats with maximum of 4 places decimal digits) ***\n");
  	printf("Enter 3 sides of triangle : ");
  	scanf("%f%f%f",&A,&B,&C);
  	a = (int) (10000*A);
  	if( ((int) (100000*A))%10 >=5)
      a++;
  	      
  	b = (int) (10000*B);
  	if( ((int) (100000*B))%10 >=5)
      b++;
  	
  	c = (int) (10000*C);
  	if( ((int) (100000*C))%10 >=5)
      c++;
  	
  	//printf("%.10f %.10f %.10f\n",A,B,C);
  	//printf("%d %d %d\n",a,b,c);
  	if (a==0 || b==0 || c==0) {
      printf("%.4f, %.4f and %.4f are NOT sides of triangle.\n",A,B,C);
    } else if ( (a*a == b*b + c*c) || (b*b == a*a+c*c) || (c*c == a*a+b*b) ) {
      	printf("%.4f, %.4f and %.4f are sides of RIGHT triangle.\n",A,B,C);
    } else if (a<b+c && b<a+c && c<a+b) {
      	printf("%.4f, %.4f and %.4f are NOT sides of RIGHT triangle, just a TRIANGLE.\n",A,B,C);
    } else {
      printf("%.4f, %.4f and %.4f are NOT sides of triangle.\n",A,B,C);
    }
	return 0;
}