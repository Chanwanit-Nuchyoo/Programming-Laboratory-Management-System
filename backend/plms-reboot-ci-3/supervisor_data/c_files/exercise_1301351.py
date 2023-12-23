print(" *** Min Max Avg ***")
a,b,c = input("Enter 3 numbers : ").split()
a,b,c = float(a),float(b),float(c)
if (a>=b and a>=c) :
    max=a
if (b>=a and b>=c) :
    max=b
if (c>=b and c>=a) :
    max=c
if (a<=b and a<=c) :
    min=a
if (b<=a and b<=c) :
    min=b
if (c<=b and c<=a) :
    min=c
mid = a+b+c-max-min
print("min, mid, max ==> {0}, {1}, {2}".format(min,mid,max))
print("Average ==> {0:0.2f}".format((min+mid+max)/3))