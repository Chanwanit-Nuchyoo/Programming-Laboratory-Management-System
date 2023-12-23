'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 1	ครั้งที่ : 0001
 * Assigned : Tuesday 23rd of August 2022 09:43:37 PM --> Submission : Friday 26th of August 2022 06:48:22 PM	
 * Elapsed time : 4144 minutes.
 * filename : ch4_1.py
'''
def absolute(num):
    try :
        num=int(num)
    except:
        try:
            num=float(num)
        except:
            return "Not valid input !!!"
    if(num>=0):
        return num
    elif(num<0):
        x=num-2*num
        return x
print(" *** Absolute value ***") 
numA, numB, numC = input("Input num1 num2 num3 : ").split()
print("Absolute of",numA,"is",absolute(numA))
print("Absolute of",numB,"is",absolute(numB))
print("Absolute of",numC,"is",absolute(numC))