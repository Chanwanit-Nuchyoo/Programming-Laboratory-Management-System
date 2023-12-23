'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 5	item : 3	ครั้งที่ : 0001
 * Assigned : Monday 29th of August 2022 12:32:28 PM --> Submission : Monday 29th of August 2022 01:45:34 PM	
 * Elapsed time : 73 minutes.
 * filename : ch5_3.py
'''
import math
print(' *** Factorial ***')
n = input("Enter an integer(n) : ")
n = int(n)
a = int(n)
i = n+1
print('Fac(',end = '')
print(n,end = '')
print(') => ',end = '')
while n > 0 :
    i = i-1
    n = n-1
    print(i,end = '')
    if i > 1 :
        print('*',end = '')
print(' =',math.factorial(a))