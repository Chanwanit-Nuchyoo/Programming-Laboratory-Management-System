#include<stdio.h>
int main() {
  	unsigned int n, t;
  	printf(" *** Display integer in comma format ***\n");
  	printf("Enter an integer : ");
  	scanf("%d",&n);
  	printf("%d in comma format = ",n);
  	if (n>=1000000000) { // more than 9 digits
      	printf("%d,",n/1000000000);
      	t = n/1000000%1000; // หลักล้าน ถึง พันล้าน
      	if(t==0)
    		printf("000,"); //  display three zero
  		else if(t<10)
      		printf("00%d,",t); // add two zero prefix
  		else if(t<100)
      		printf("0%d,",t); // add one zero prefix
      	else 
      		printf("%d,",t); // no zero prefix
       	t = n/1000%1000; // หลักพัน ถึง แสน
      	if(t==0)
    		printf("000,"); //  display three zero
  		else if(t<10)
      		printf("00%d,",t); // add two zero prefix
  		else if(t<100)
      		printf("0%d,",t); // add one zero prefix
      	else 
      		printf("%d,",t); // no zero prefix
      	      	
      	t = n%1000; //หลักหน่วยถึงพัน
      	if(t==0)
    		printf("000.\n"); //  display three zero
  		else if(t<10)
      		printf("00%d.\n",t); // add one zero prefix
  		else if(t<100)
      		printf("0%d.\n",t); // add two zero prefix
      	else 
          	printf("%d.\n",t);
      
    } else if (n>=1000000) { // more than 6 digits
    	printf("%d,",n/1000000);
      	t = n/1000%1000; // หลักพัน ถึง แสน
      	if(t==0)
    		printf("000,"); //  display three zero
  		else if(t<10)
      		printf("00%d,",t); // add two zero prefix
  		else if(t<100)
      		printf("0%d,",t); // add one zero prefix
      	else 
      		printf("%d,",t); // no zero prefix
      	      	
      	t = n%1000; //หลักหน่วยถึงพัน
      	if(t==0)
    		printf("000.\n"); //  display three zero
  		else if(t<10)
      		printf("00%d.\n",t); // add one zero prefix
  		else if(t<100)
      		printf("0%d.\n",t); // add two zero prefix
      	else 
          	printf("%d.\n",t);
    } else if(n>=1000) { // more than 3 digits
      	printf("%d,",n/1000);
      	t = n%1000; //หลักหน่วยถึงพัน
      	if(t==0)
    		printf("000.\n"); //  display three zero
  		else if(t<10)
      		printf("00%d.\n",t); // add one zero prefix
  		else if(t<100)
      		printf("0%d.\n",t); // add two zero prefix
      	else 
          	printf("%d.\n",t);
          
      
    } else  { //ไม่เกินสามหลัก
    	printf("%d.\n",n);
    }
  
	return 0;
}