'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 1	ครั้งที่ : 0001
 * Assigned : Monday 15th of August 2022 02:48:43 PM --> Submission : Monday 15th of August 2022 03:19:47 PM	
 * Elapsed time : 31 minutes.
 * filename : ch3_1.py
'''
print(" *** Integer type and odd even ***")
x = input("Enter any number : ")
x = int (x)
if (x == 0) :
    print(x, "is zero.")
if (x < 0) :
    print(x, "is negative.")
if (x > 0) :
    print(x, "is positive.")
if (x%2 == 0) :
    print(x, "is even.")
else :
    print(x, "is odd.")