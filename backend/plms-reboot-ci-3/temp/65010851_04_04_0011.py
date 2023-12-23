'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 4	ครั้งที่ : 0011
 * Assigned : Tuesday 23rd of August 2022 10:09:10 PM --> Submission : Friday 26th of August 2022 07:30:45 PM	
 * Elapsed time : 4161 minutes.
 * filename : ch4_4.py
'''
def xIntercept(m,c):
    if(m==0):
        return "Not Available"
    if(c==0):
        return "0"
    else :
        x=-(c/m)
        if((x%1)==0):
            x=int(x)
        return str(x)
def yIntercept(m,c):
    if(c==0):
        return "0"
    else :
        y=c
        if((y%1)==0):
            y=int(y)
        return str(y)

print(" *** XY Intercept y = mx + c ***")
m,c = input("Enter m c : ").split()
m=float(m)
c=float(c)
print ("x-intercept =", xIntercept(m,c))
print ("y-intercept =", yIntercept(m,c))
