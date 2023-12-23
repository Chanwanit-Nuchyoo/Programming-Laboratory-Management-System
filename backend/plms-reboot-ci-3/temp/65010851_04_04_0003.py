'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 4	ครั้งที่ : 0003
 * Assigned : Tuesday 23rd of August 2022 10:09:10 PM --> Submission : Friday 26th of August 2022 07:16:07 PM	
 * Elapsed time : 4146 minutes.
 * filename : ch4_4.py
'''
def xIntercept(m,c):
    if(m==0,c==0):
        return "Not Available"
    else :
        x=c/m
        return str(x)
def yIntercept(m,c):
    if(m==0,c==0):
        return "Not Available"
    else :
        y=m-c
        return str(y)

print(" *** XY Intercept y = mx + c ***")
m,c = input("Enter m c : ").split()
m=float(m)
c=float(c)
print ("x-intercept =", xIntercept(m,c))
print ("y-intercept =", yIntercept(m,c))
