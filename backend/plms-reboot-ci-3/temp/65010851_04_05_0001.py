'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 5	ครั้งที่ : 0001
 * Assigned : Tuesday 23rd of August 2022 10:09:29 PM --> Submission : Friday 26th of August 2022 06:46:36 PM	
 * Elapsed time : 4117 minutes.
 * filename : ch4_5.py
'''
def triangleChecker(a,b,c):
    #put code below
    a=float(a)
    b=float(b)
    c=float(c)
    x=max(a,b,c)
    if((a<0)or(b<0)or(c<0)):
        print("INPUTs cannot be negative.")
    elif((a==0)or(b==0)or(c==0)):
        print("Side of triangle must not be zero.")
    elif((a==b)and(a==c)):
        print("==> Equilateral Triangle")
    elif((a==b)or(a==c)or(b==c)):
        print("==> Isosceles Triangle.")
    else:
        if((a>b)and(a>c)):
            if(not(a<(b+c))):
                print("==> NOT VALID sides")
            elif(a*a)==(b*b)+(c*c):
                print("==> Right Triangle")
            else:
                print("==> Triangle.")
        elif((b>a)and(b>c)):
            if(not(b<(a+c))):
                print("==> NOT VALID sides")
            elif((b*b)==(a*a)+(c*c)):
                print("==> Right Triangle")
            else:
                print("==> Triangle.")
        elif((c>a)and(c>b)):
                if(not(c<(a+b))):
                    print("==> NOT VALID sides")
                elif((c*c)==(a*a)+(b*b)):
                    print("==> Right Triangle")
                else:
                    print("==> Triangle.")

print(" *** Triangle Checker ***")
a,b,c = input("Enter side1 side2 side3 : ").split()
triangleChecker(a,b,c)
    

    
    

