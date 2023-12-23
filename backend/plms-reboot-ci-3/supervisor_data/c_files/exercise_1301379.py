print(" *** (Mid*Mid)/Min ***")
a,b,c=input("Enter 3 numbers : ").split()
a,b,c = float(a),float(b),float(c)
max = a
if b>=c:
    if b>=a:
        max = b
if c>=a:
    if c>=b:
        max = c
min = a
if b<=c:
    if b<=a:
        min = b
if c<=a:
    if c<=b:
        min = c
mid = a+b+c-(max+min)
#print("min={0} mid={1} max={2}".format(min,mid,max))
if min==0:
    print("Invalid input !!!")
    quit()
result = (mid*mid)/min
if result == int(result):
    result = int(result)
print("(mid*mid)/min ==>",result)