def triangleChecker(a,b,c):
    #put code below
    a,b,c = float(a), float(b),float(c)
    if a<0 or b<0 or c<0:
        print("INPUTs cannot be negative.")
        quit()
    if a==0 or b==0 or c==0:
        print("Side of triangle must not be zero.")
        quit()
    if a==b and b==c:
        print("==> Equilateral Triangle")
        quit()
    if a>=b and a>=c:
        max=a
    elif b>=a and b>=c:
        max=b
    else:
        max=c
    if a<=b and a<=c:
        min=a
    elif b<=a and b<=c:
        min=b
    else:
        min=c
    mid = a+b+c-max-min
    if max>min+mid:
        print("==> NOT VALID sides.")
        quit()
    
    if min==mid and max**2 == mid**2 + min**2:
        print("==> Isosceles right-angled Triangle.")
        quit()
    if max**2 == mid**2 + min**2:
        print("==> Right Triangle.")
        quit()
    if max==mid:
        print("==> Isosceles Triangle.")
        quit()
    print("==> Triangle.")
    
    
print(" *** Triangle Checker ***")
a,b,c = input("Enter side1 side2 side3 : ").split()
triangleChecker(a,b,c)