#include<stdio.h>
int main() {
  	int x=0,length=0,bracket_start=0,bracket_end=0,brackets=0;
  	char input[200];
  	printf(" *** Count number of brackets ***\n");
  	printf("Enter expression : ");
  	scanf("%[^\n]",input);
  	printf("expression : %s\n",input);
  	length = 0;
  	while(input[length]!='\0')
      length++;
  	printf("length : %d\n",length);
  
  	for(x=0;x<length;x++) {
      if(input[x]=='(')
        bracket_start++;
      else if(input[x]==')')
        bracket_end++;
    }
  	if(bracket_start==0 && bracket_end==0) {
      printf("There is NO bracket in %s\n",input);
    } else if(bracket_start==1 && bracket_end ==1) {
      printf("There is 1 bracket in %s\n",input);
    } else if(bracket_start==bracket_end) {
      brackets = bracket_end;
      printf("There are %d brackets in %s\n",brackets,input);
    } else {
      printf("%s ===> bracket doesn't match.\n",input);
    }
   
	return 0;
}