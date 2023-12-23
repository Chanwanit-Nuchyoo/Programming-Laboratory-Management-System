#include<stdio.h>
int main() {
	float a;
	printf("%-7s%s ","input",":");
	scanf("%f",&a);
	printf("%-7s%s %.1f","output",":",a*0.3);

	return 0;
}
