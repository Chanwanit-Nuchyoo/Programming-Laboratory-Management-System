def hcfnaive(a,b): 
    if(b==0):
        if a<0:
            a=a*(-1) 
        return a 
    else:
        return hcfnaive(b,a%b) 
  
a,b = input("Enter Input : ").split()
if int(a)==0 and int(b)==0:
    print("Error! must be not all zero.")
else:
    if b>a:
        a,b = b,a
    print ("The gcd of {0} and {1} is : ".format(a,b),end="") 
    print (hcfnaive(int(a),int(b))) 