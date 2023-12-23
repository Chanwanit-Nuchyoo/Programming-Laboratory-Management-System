'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 2	ครั้งที่ : 0003
 * Assigned : Monday 15th of August 2022 03:20:06 PM --> Submission : Monday 15th of August 2022 03:48:34 PM	
 * Elapsed time : 28 minutes.
 * filename : ch3_2.py
'''
print(" *** Min Max Avg ***")
a,b,c = input("Enter 3 numbers : ").split()
a = float(a)
b = float(b)
c = float(c)
if (a<b) :
    if (a<c) :
        print("min, mid, max ==>",a, b, c)
    if (a>c) :
        print("min, mid, max ==>",c, a, b)
if (a>b) :
    if (a<c) :
        print("min, mid, max ==>",b, a, c)
    if (a>c) :
        print("min, mid, max ==>",c, b, a)
if (a==b==c) :
    print("min, mid, max ==>",a, b, c)
d = a+b+c
d = d/3
print("Average ==> %.2f" %d)
