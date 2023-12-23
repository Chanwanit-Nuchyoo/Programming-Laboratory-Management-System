'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 2	item : 3	ครั้งที่ : 0006
 * Assigned : Monday 8th of August 2022 03:24:51 PM --> Submission : Monday 8th of August 2022 03:32:00 PM	
 * Elapsed time : 7 minutes.
 * filename : ch2_3.py
'''
print(" *** Finding circle area *** ")
diameter = input("Enter diameter : ")
diameter = float(diameter/2)
pi = 3.1415926
circleArea = pi*diameter**2
print("Circle area =", circleArea)
print("Circle area = %.2f" %circleArea) # แสดงผลทศนิยม 2 ตำแหน่ง
print("whole number =>",int(circleArea)) # แสดงผลเฉพาะส่วนที่เป็นจำนวนเต็ม