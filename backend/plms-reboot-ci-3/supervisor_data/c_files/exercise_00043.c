#include<stdio.h>
int main() {
  float f;
  printf(" *** Get float from keyboard *** \n");
  printf("Enter a float : ");
  scanf("%f",&f);
  printf(" 2 places decimal digit : %.2f\n",f);
  printf(" 4 places decimal digit : %.4f\n",f);
  printf(" 6 places decimal digit : %.6f\n",f);
  printf(" 8 places decimal digit : %.8f\n",f);
  printf("floor : %d\n",(int) f);
  
	return 0;
}