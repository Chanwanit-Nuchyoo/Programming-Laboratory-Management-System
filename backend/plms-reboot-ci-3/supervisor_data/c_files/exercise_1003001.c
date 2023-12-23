#include<stdio.h>
int main() {
  char ch;
  printf(" *** Show a character in variety formats. *** \n");
  printf("Enter a character : ");
  scanf("%c",&ch);
  printf("\n\tInput  : %c\n",ch);
  printf("\tASCII  : %d\n",ch);
  printf("\tSquare : %d\n",ch*ch);
 
  
	return 0;
}