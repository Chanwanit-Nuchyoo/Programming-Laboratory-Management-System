'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 2	ครั้งที่ : 0001
 * Assigned : Tuesday 23rd of August 2022 10:06:43 PM --> Submission : Friday 26th of August 2022 06:47:51 PM	
 * Elapsed time : 4121 minutes.
 * filename : ch4_2.py
'''
def quadraticChecker(a :float, b :float, c :float):
    if(a!=0):
        x=(b*b)-(4*a*c)
        if (x<0):
            return 0
        elif(x==0):
            return 1
        else:
            return 2
    else :
        print("a must NOT be zero !!!")
        exit()
    # Enter your code

print(" *** Quadratic Checker *** ")
print("     ax^2 + bx + c = 0     ")
a,b,c = input("Enter a b c : ").split()
# Enter your code below
try :
    a=float(a)
    b=float(b)
    c=float(c)
except :
    print("Please enter VALID a, b and c !!!")
checker = quadraticChecker(a,b,c) # invoke function
if checker==0:
    print("There is NO VALID solution.")
elif checker == 1:
    print("There is only ONE solution.")
else:
    print("There are TWO solutions.")