#include<stdio.h>
int main() {
  	char str[200];
  	int i,firstletter=0;
  	printf(" *** Show Title Case. ***\n");
  	printf("Enter a line of characters : ");
  	scanf("%[^\n]",str);
  	for(i=0; str[i]!='\0'; i++) {
      	while(str[i] == ' ')
          i++;
      	      	
      	if(str[i]>='a' && str[i]<='z' && (i==0 || str[i-1]==' ')) {
          	str[i] = str[i]-32;
        }
      	
      	if(str[i]>='A' && str[i]<='Z' && 
           	((str[i-1]>='A' && str[i-1]<='Z') || 
           	(str[i-1]>='a' && str[i]<='z'))) {
          	str[i] = str[i]+32;
        }
      	
    }
  	printf("output :\n");
  	printf("%s\n",str);
  	
	return 0;
}