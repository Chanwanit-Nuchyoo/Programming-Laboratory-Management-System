#include<stdio.h>
int main() {
	int a,b;
	printf("%-7s%s ","input",":");
	scanf("%d%d",&a,&b);
	printf("%-7s%s %.1f","output",":",(a+b)/2.0);

	return 0;
}
