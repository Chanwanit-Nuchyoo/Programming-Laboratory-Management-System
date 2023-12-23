'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 4	ครั้งที่ : 0004
 * Assigned : Monday 15th of August 2022 04:29:06 PM --> Submission : Monday 15th of August 2022 08:36:13 PM	
 * Elapsed time : 247 minutes.
 * filename : ch3_4.py
'''
print(" *** 3-digit odd even ***")
d,e,f = input("Enter 3-digit number : ")
a = float(d)
b = float(e)
c = float(f)
if (a%2 == 0) :
    a='even'
if (b%2 == 0) :
    b='even'
if (c%2 == 0) :
    c='even'
else :
    a='odd'
    b='odd'
    c='odd'
print(f"{d},{e},{f}=>",a,b,c)