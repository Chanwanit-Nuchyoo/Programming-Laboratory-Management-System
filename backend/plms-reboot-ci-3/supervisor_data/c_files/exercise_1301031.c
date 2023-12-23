/*
 * กลุ่มที่  : 18010008
 * 59010974 พิมพ์พิสุทธิ์ แก้วมหานิล
 * chapter : 4	item : 5	ครั้งที่ : 0004
 * Assigned : Saturday 1st of September 2018 09:43:35 AM --> Submission : Monday 3rd of September 2018 08:09:15 PM	
 * Elapsed time : 3505 minutes.
 * filename : lab4.5.c
 */
#include<stdio.h>
int main()
{long  num1;
    printf(" *** Display integer in comma format ***\n");
    printf("Enter an integer : ");
    scanf("%ld",&num1);
 printf("num:%d",num1);
 
 // if (num1 <= 999 )
   
 if(num1<=999){
	  printf( "\n%d in comma format = %d.\n",num1,num1 );
   }else {
     printf( "\n%d in 555comma format = %d.\n",num1,num1 );
  }
 /*
  else if (num1 > 999 && num1 <= 9999 )  
   {  
	  printf ("%d in comma format = %d,%.3d.",num1,num1/1000,num1%1000 );
   }
  else if (num1 > 9999 && num1 <= 99999 )  
   {  
	  printf ("%d in comma format = %d,%.3d.",num1,num1/1000,num1%1000 );
   }
  else if (num1 > 99999 && num1 <= 999999 )  
   {  
	  printf ("%d in comma format = %d,%.3d.",num1,num1/1000,num1%1000 );
   }
  else if (num1 > 999999 && num1 <= 9999999)  
   {  
	  printf ("%d in comma format = %d,%.3d,%.3d.",num1,num1/1000000,(num1%1000000-num1%1000)/1000,num1%1000 );
   }
  else if (num1 > 9999999 && num1 <= 99999999)  
   {  
	  printf ("%d in comma format = %d,%.3d,%.3d.",num1,num1/1000000,(num1%1000000-num1%1000)/1000,num1%1000 );
   }
  else if (num1 > 99999999 && num1 <= 999999999)  
   {  
	  printf ("%d in comma format = %d,%.3d,%.3d.",num1,num1/1000000,(num1%1000000-num1%1000)/1000,num1%1000 );
   }
  else if (num1 > 999999999 && num1 <= 9999999999)  
   {  
	  printf ("%d in comma format = %d,%d,%.3d,%.3d.",num1,num1/1000000000,(num1%1000000000-num1%1000000)/1000000,(num1%1000000-num1%1000)/1000,num1%1000 );
   }
  
*/
 
  
return 0 ;
}

