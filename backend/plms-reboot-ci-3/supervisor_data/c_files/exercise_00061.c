#include<stdio.h>
int main() {
  int year,month;
  printf(" *** Show Calendar ***\n");
  printf("Enter year and month (2015-8) : ");
  scanf("%d-%d",&year,&month);
  printf("+-----------------------------------------+\n");
  printf("|%22d%19s|\n",year,"");
  printf("|-----+-----+-----+-----+-----+-----+-----+\n");
  printf("| Sun | Mon | Tue | Wed | Thu | Fri | Sat |\n");
  printf("|-----+-----+-----+-----+-----+-----+-----+\n");
  printf("year = %d  month = %d\n",year,month);
	return 0;
}