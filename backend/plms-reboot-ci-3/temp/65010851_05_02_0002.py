'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 5	item : 2	ครั้งที่ : 0002
 * Assigned : Monday 29th of August 2022 12:09:50 PM --> Submission : Monday 29th of August 2022 01:09:48 PM	
 * Elapsed time : 59 minutes.
 * filename : ch5_2.py
'''
print(' *** integer summation from 1 to n ***')
n = input("Enter an integer(n) : ")
n = int(n)
i = 0
print('Summation => ',end = '')
while n > i :
    i = i + 1
    print(i,end = '')
    if i < n :
        print('+',end = '')
print(' =',n * (n + 1) // 2)