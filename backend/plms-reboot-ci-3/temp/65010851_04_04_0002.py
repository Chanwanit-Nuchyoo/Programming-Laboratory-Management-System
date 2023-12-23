'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 4	ครั้งที่ : 0002
 * Assigned : Tuesday 23rd of August 2022 10:09:10 PM --> Submission : Friday 26th of August 2022 06:46:50 PM	
 * Elapsed time : 4117 minutes.
 * filename : ch4_4.py
'''
def slope(a,b,c):
    if(b==0) :
        print("Slope = Not Available")
    else :
        print("Slope = ",end="")
        m=-(a/b)
        if((a%b)==0) :
            m=int(m)
        print(m)
def xIntercept(a,b,c):
    if(a==0):
        return "Not Available"
    else :
        x=-(c/a)
        if((c%a)==0):
            x=int(x)
        return str(x)
def yIntercept(a,b,c):
    if(b==0):
        return "Not Available"
    else :
        y=-(c/b)
        if((c%b)==0):
            y=int(y)
        return str(y)

print(" *** XY  Intercept ***\n -- ax + by + c = 0 --")
a,b,c = input("Enter a b c : ").split()
a=float(a)
b=float(b)
c=float(c)
slope(a,b,c)
print("x-intercept => " + xIntercept(a,b,c))
print("y-intercept => " + yIntercept(a,b,c))
