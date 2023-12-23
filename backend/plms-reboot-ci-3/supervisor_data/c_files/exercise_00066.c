#include<stdio.h>
int main() {
	unsigned int n,x,sum=0,digits=1,temp,display_position=0,digit;
	int i;
	printf(" *** Summation of each digit into one digit ***\n");
	printf("Enter a positive number : ");
	scanf("%d",&n);
	temp=n;
	while (temp >= 10) {
		temp /= 10;
		digits++;
	}
	//printf("digits = %d\n",digits);
	printf("%d",n);

	sum = 0;
	for(i=digits; i>=0; i--) {
		//printf("\nloop = %d\n",i);
		display_position = i;
		temp = n;
		for(x=1;x<display_position;x++) {
			temp /=10;          	
		}
		if(i>0)
			digit = temp %10;
		else
			digit=0;
		sum += digit;
		//printf("temp=%d  digit=%d\n",temp,digit);

		if (display_position==digits) {
			printf(" => %d",temp);
		} else if(display_position == 0) {
			if(sum<10) {
				printf(" = %d\n",sum);
			} else {
				printf(" = %d => %d + %d = %d\n",sum,sum/10,sum%10,sum/10+sum%10);

			}

		} else {
			printf(" + %d", digit);
		}
	}

	return 0;
}