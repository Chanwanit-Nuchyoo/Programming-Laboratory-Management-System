#include<stdio.h>
int main() {
	int a,b,c,max,min,mid;
	printf("Enter 3 numbers : ");
	scanf("%d %d %d",&a,&b,&c);
	if ((a>=b) && (b>=c)) {max = a;mid = b;min=c;}
	else if((a>=c) && (c>=b)) {max = a;mid = c;min=b;}
	else if((b>=a) && (a>=c)) {max = b;mid = a;min=c;}
	else if((b>=c) && (c>=a)) {max = b;mid = c;min=a;}
	else if((c>=a) && (a>=b)) {max = c;mid = a;min=b;}
	else  {max = c;mid = b;min=a;}
	printf("%-40d%40d%840s%d",max,min,"",mid);
	return 0;
}