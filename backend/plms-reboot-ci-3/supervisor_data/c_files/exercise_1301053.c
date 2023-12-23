#include<stdio.h>
int main() {
    int num,i;
    printf(" *** Display integer in Hexadecimal and 2\'s Complement format ***\n");
    printf("Enter a number : ");
    scanf("%d",&num);
    printf("%10d in Hexadecimal    : %08x \n",num,num);
    printf("%10d in 2\'s Complement : ",num);
    for(i=0;i<sizeof(int)*8;i++) {
      if (((num<<i) & 0x80000000) == 0 )
          printf("0");
      else
          printf("1");
      if (  ((i+1)%4)==0)
          printf(" ");
    }
    printf("\n");
	return 0;
}