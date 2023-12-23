#include<stdio.h>
int main() {
	int a;
	printf("%-7s%s ","input",":");
	scanf("%d",&a);
	printf("%-7s%s %.1f","output",":",a/2.0);
	return 0;
}
