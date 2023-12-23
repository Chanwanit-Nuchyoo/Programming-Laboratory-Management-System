#include<stdio.h>
int main() {
  	char str[200];
  	int i,firstletter=0;
  	printf(" *** Single space ***\n");
  	printf("Enter a line of characters : ");
  	scanf("%[^\n]",str);
  	printf("Single space output :\n");
  	//printf("%s\n",str);
  	//skip leading space
    i=0;
    while(str[i]==' ' )
    	i++;
  	for(i=i; str[i]!='\0'; i++) {
      	
      	if( str[i] != ' ' ) {
          	printf("%c",str[i]);
        } else if( str[i] ==' ' && str[i-1]!=' ') {
          	printf(" ");
        }
        
      	
    }
  	
  	
  	
	return 0;
}