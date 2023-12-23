'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 2	item : 5	ครั้งที่ : 0001
 * Assigned : Monday 8th of August 2022 03:39:42 PM --> Submission : Monday 8th of August 2022 04:10:36 PM	
 * Elapsed time : 30 minutes.
 * filename : ch2_5.py
'''
print(" *** Number Fun !!! ***")
a,b = input("Enter a b : ").split()
print("a=",a,"\ttype =",type(a))
print("b=",b,"\ttype =",type(b))
a = int(a) # convert a to int
b = int(b) # convert b to int
q=a/b
w=b/a
e=a//b
r=b//a
E=a%b
R=b%a
print("a/b = %.2f" %q) # แสดงผล a/b ทศนิยม 2 ตำแหน่ง
print("b/a = %.3f" %w) # แสดงผล b/a ทศนิยม 3 ตำแหน่ง
print("a/b = ",e," r ",E) # แสดงผลการหารแบบเหลือเศษของ a และ b
print("b/a = ",r," r ",R) # แสดงผลการหารแบบเหลือเศษของ b และ a