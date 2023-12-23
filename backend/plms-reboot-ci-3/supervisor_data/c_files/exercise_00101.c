#include<stdio.h>
#include<math.h>
int main() {
  int a;
  printf(" *** Show absolute value ***\n");
  printf("Enter an integer : ");
  scanf("%d",&a);
  printf("Absolute value of %d is |%d| = %d",a,a,abs(a));

	return 0;
}