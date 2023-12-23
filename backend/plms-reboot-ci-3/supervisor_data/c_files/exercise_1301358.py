def quadraticChecker(a :float, b :float, c :float):
    check = b*b - (4*a*c)
    if check==0:
        return 1
    elif check<0:
        return 0
    else:
        return 2
print(" *** Quadratic Checker *** ")
print("     ax^2 + bx + c = 0     ")
a,b,c = input("Enter a b c : ").split()
try:
    a = float(a)
    b = float(b)
    c = float(c)
except:
    print("Please enter VALID a, b and c !!!")
    quit()
if (a==0):
    print("a must NOT be zero !!!")
    quit()
checker = quadraticChecker(a,b,c)
if checker==0:
    print("There is NO VALID solution.")
elif checker == 1:
    print("There is only ONE solution.")
else:
    print("There are TWO solutions.")
