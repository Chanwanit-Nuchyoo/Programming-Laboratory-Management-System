'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 3	item : 3	ครั้งที่ : 0004
 * Assigned : Monday 15th of August 2022 04:18:09 PM --> Submission : Monday 15th of August 2022 09:47:59 PM	
 * Elapsed time : 329 minutes.
 * filename : ch3_3.py
'''
print(" *** Data type integer float string ***")
x = input("Enter a word : ")
try:
    numFloat = float(x)
    numInt = int(numFloat)
    numDiff = numFloat-numInt
    if numDiff != 0.0 :
        print('%.3f'%numFloat,'/ 3 = %.3f'%(numFloat/3))
    else :
        print(numInt,"* 2 =",numInt*2)
except :
    print(x,x,x)