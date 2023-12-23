#include <stdio.h>
#include <conio.h>
int main()
{
	int x;
	printf(" *** switch control structure ***\n");
	printf("Enter a number : ");
	scanf("%d",&x);
	
	switch (x%3)
	{
	case 0: puts("Hello, world!");break;
	case 1: puts("Hello, what a wonderful world.");break;
	default: puts("Hello, it is a beautiful day");break;
	}

	return 0;
}
