def xIntercept(m,c):        
    m = float(m)
    c = float(c)
    if m==0:
        return "Not Available"
    if c==0:
        return "0"
    if c/m == int(c/m):
        return str(-1*int(c/m))
    return str(-1*c/m)
def yIntercept(m,c):        
    return c    
    
print(" *** XY Intercept y = mx + c ***")
m,c = input("Enter m c : ").split()
print ("x-intercept =", xIntercept(m,c))
print ("y-intercept =", yIntercept(m,c))