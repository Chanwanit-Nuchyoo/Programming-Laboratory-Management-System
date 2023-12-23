'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 4	ครั้งที่ : 0005
 * Assigned : Tuesday 23rd of August 2022 10:09:10 PM --> Submission : Friday 26th of August 2022 07:17:38 PM	
 * Elapsed time : 4148 minutes.
 * filename : ch4_4.py
'''
def xIntercept(m,c):
    if(c==0):
        return "Not Available"
    else :
        x=c/m
        return str(x)
def yIntercept(m,c):
    if(c==0):
        return "0"
    else :
        y=m-c
        return str(y)

print(" *** XY Intercept y = mx + c ***")
m,c = input("Enter m c : ").split()
m=float(m)
c=float(c)
print ("x-intercept =", xIntercept(m,c))
print ("y-intercept =", yIntercept(m,c))
