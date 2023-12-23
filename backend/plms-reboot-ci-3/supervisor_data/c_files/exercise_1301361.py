def slope(a,b,c):
    a,b,c= float(a), float(b), float(c)
    if b==0:
        return "Not Available"
    slope = -1*a/b
    if slope == int(slope):
        return str(int(slope))
    return str(slope)
    
def xIntercept(a,b,c):        
    a,b,c = float(a),float(b),float(c)
    if a==0 and b==0 :
        return "Not Available"
    if c==0:
        return "0"
    if int(-1*c/a) == (-1*c/a):
        return str(int(-1*c/a))
    return str(-1*c/a)
    
def yIntercept(a,b,c):  
    a,b,c = float(a),float(b),float(c)
    if a==0 and b==0 :
        return "Not Available"
    if c==0:
        return "0"
    if int(-1*c/b) == (-1*c/b):
        return str(int(-1*c/b))
    return str(-1*c/b)
    
print(" *** XY  Intercept ***\n -- ax + by + c = 0 --")
a,b,c = input("Enter a b c : ").split()
print("Slope =",slope(a,b,c))
print ("x-intercept => " + xIntercept(a,b,c))
print ("y-intercept => " + yIntercept(a,b,c))