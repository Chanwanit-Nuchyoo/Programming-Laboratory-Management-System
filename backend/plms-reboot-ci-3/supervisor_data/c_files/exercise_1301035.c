#include<stdio.h>
int main() {
  	char ch;
  	int count;
    printf("Enter character : ");
  	for (count =1 ; count<=10 ;count++) {
  		
  		scanf("%c",&ch);
     
      	printf("%-3d ",ch);
		if (count%3==0) printf("\n");
    }
      return 0;
      
}