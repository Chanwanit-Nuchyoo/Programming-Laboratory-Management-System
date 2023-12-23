'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 2	item : 4	ครั้งที่ : 0001
 * Assigned : Monday 8th of August 2022 03:34:34 PM --> Submission : Monday 8th of August 2022 04:26:25 PM	
 * Elapsed time : 51 minutes.
 * filename : ch2_4.py
'''
print(" *** Integer division ***")
x = input("Enter a 3-digit number : ")
print(x, type(x)) # ตรวจสอบข้อมูลที่รับเข้ามา
x = float(x)    # type casting เปลี่ยน string(ข้อความ) เป็น float(ทศนิยม)
print(x,type(x))    # แสดงผลทศนิยม และ type ข้อมูล
x = int(x)            # type casting เปลี่ยน float(ทศนิยม) เป็น integer(จำนวนเต็ม
print(x, type(x))    # แสดงผลทศนิยม และ type ข้อมูล
print("divided by 25 =",x/25)    # การหารจำนวนเต็ม ผลลัพธ์ที่ได้ เป็นข้อมูลประเภททศนิยม
print("divided by 25 =",x//25," remainder = ", x%25) # การหารแบบเหลือเศษ ใช้เครื่องหมาย // (double-slash)
y = x//10
y = y%10
print("tenth-digit =",y)