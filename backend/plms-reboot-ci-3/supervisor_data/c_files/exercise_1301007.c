#include<stdio.h>
int main() {
	int a,i,j;
	printf("input : ");
	scanf("%d",&a);
	printf("\n");
	for (i=0;i<a;i++){
		for (j=a-i;j>0;j--){
			printf("%d",i+1);
		}
		printf("\n");
	}
	return 0;
}
