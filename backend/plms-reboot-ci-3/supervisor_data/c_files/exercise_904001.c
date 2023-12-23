#include<stdio.h>
#include<string.h>
void palindrome(char *);
int main() {
    char str[100];
    printf(" ***  Palindrome Verification  ***\n");
    printf(" *  verify only alphabet number  *\n");
    printf(" *        insensitive case       *\n");
    printf(" *-------------------------------*\n");
    printf("Enter a sentence : ");
    scanf("%[^\n]",str);
  printf("Entered message : %s\n",str);
   palindrome(str);
	return 0;
}

void palindrome(char * str) {
   char *p_left, *p_right;
  //printf("palin : ");
  
  for(p_right=str; *p_right!='\0';p_right++);
        p_right--;
        for(p_left=str; p_left<p_right; p_left++,p_right--) {
          while(  !( (*p_left>='a' && *p_left<='z') ||
                        (*p_left>='A' && *p_left<='Z') || 
                        (*p_left>='0' && *p_left<='9') ) )
             p_left++;
          while(  !( (*p_right>='a' && *p_right<='z') || 
                     (*p_right>='A' && *p_right<='Z') || 
                     (*p_right>='0' && *p_right<='9') )  )
             p_right--;
          if(tolower(*p_left) != tolower(*p_right))
            break;
        }
        if (p_left < p_right) {
            printf("\"%s\" is NOT palindrom.\n",str);
        } else {
            printf("\"%s\" is PALINDROME.\n",str);
        }

}
