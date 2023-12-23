#include<stdio.h>
int main() {
  char str[255];
  printf(" *** Show a word in variety formats. *** \n");
  printf("Enter a word : ");
  scanf("%s",&str);
  printf("\nInput  : %s\n",str);
  printf("%13s%13s\n",str,str);
  printf("%13s%13s%13s\n",str,str,str);
  printf("%13.1s%13.2s%13.3s%13.4s\n",str,str,str,str);
  printf("%-13.1s%-13.2s%-13.3s%-13.4s\n",str,str,str,str);
 
  
	return 0;
}