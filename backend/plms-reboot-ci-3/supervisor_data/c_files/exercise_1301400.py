def isValidSides(a,b,c):
    if a >= b and a >= c:
        max = a
    elif b >= a and b >= c :
        max = b
    else:
        max = c
    if a <= b and a <= c :
        min = a
    elif b <= a and b <= c :
        min = b
    else:
        min = c
    mid = a+b+c-max-min
    if max >= mid+min :
        return False
    elif a <= 0 or b <= 0 or c <= 0:
        return False
    else:
        return True

def isIsoscelesTriangle(a,b,c):
    if a == b or b == c or a == c:
        return True
    else:
        return False

print(' *** Isosceles Triangle ***')
a,b,c = input("Enter length of triangle sides: ").split()
try:
    a,b,c = int(a),int(b),int(c)
except:
    print('Not number')
    quit()

if isValidSides(a,b,c):
    if isIsoscelesTriangle(a,b,c):
        print('Isosceles triangle')
    else:
        print('Not Isosceles triangle')
else:
    print('Not valid sides.')