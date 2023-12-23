'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 5	item : 5	ครั้งที่ : 0002
 * Assigned : Monday 29th of August 2022 12:41:26 PM --> Submission : Monday 29th of August 2022 07:24:24 PM	
 * Elapsed time : 402 minutes.
 * filename : ch5_5.py
'''
print(' *** even integer summation from 1 to n ***')
n = input("Enter an integer(n) : ")
n = int(n)
i = 0
print('Summation => ',end = '')
while i < n > 0 :
    if n%2 == 0 :
        i = i+2
    print(i,end = '')
    if i < n :
        print('+',end = '')
    m = i
print(' =',((2+m)*(n//2))//2)