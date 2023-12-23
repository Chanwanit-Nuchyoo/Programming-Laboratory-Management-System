#include<stdio.h>
int main() {
  char str1[] = "Computer Programming is fun.";
  char str2[] = "Programming";
  printf("%-40.7s%40s%1840s%50.20s",str2,str2,"",str1);
	return 0;
}