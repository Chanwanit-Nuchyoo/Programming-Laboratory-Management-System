#include<stdio.h>
#include<string.h>
#include<ctype.h>
int main() {
    char str[256],i,ch;
    printf("Enter a string : ");
    scanf("%[^\n]",str);
  
    printf("Capital : ");
  	// line 1
    for(i=0;str[i]!='\0';i++)
        printf("%c",toupper(str[i]));
    printf("\n");
  
  // line 2
    printf("Small : ");
    for(i=0;str[i]!='\0';i++)
        printf("%c",tolower(str[i]));
    printf("\n");
  
  	// line 3
    printf("Title : ");
    for(i=0;str[i]!='\0';i++) {
      	if(i==0 || str[i-1]==' ')
           printf("%c",toupper(str[i]));
      else
        printf("%c",tolower(str[i]));
    }
    printf("\n");
  
	return 0;
}