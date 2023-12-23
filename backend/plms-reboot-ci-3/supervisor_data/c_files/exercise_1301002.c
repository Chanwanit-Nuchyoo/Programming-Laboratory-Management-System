#include<stdio.h>
int main() {
	int a,i,j;
	printf("input : ");
	scanf("%d",&a);
	printf("\n");
	for (i=0;i<a;i++){
		for (j=0;j<i+1;j++){
			printf("%d",a-j);
		}
		printf("\n");

	}
	return 0;
}
