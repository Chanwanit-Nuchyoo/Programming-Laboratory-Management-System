#include<stdio.h>
#include<string.h>
#include<ctype.h>
int main() {
    char str[256],i;
    printf("Enter a string : ");
    scanf("%[^\n]",str);
  
    printf("Capital : ");
    for(i=0;str[i]!='\0';i++)
        printf("%c",toupper(str[i]));
    printf("\n");
    printf("Small : ");
    for(i=0;str[i]!='\0';i++)
        printf("%c",tolower(str[i]));
    printf("\n");
  
	return 0;
}