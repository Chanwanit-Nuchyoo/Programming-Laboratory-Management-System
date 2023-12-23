def isValidScore(a,b,c):
    if a < 0 or a > 100:
        return False
    elif b < 0 or b > 100:
        return False
    elif c < 0 or c > 100:
        return False
    else:
        return True

def computeMiddleGrade(a,b,c) :
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
    if mid >= 80:
        return "A"
    elif mid >= 70:
        return "B"
    elif mid >= 60:
        return "C"
    elif mid >= 50:
        return "D"
    else:
        return "F"

a,b,c = input("Enter score of 3 subjects: ").split()
try:
    a,b,c = int(a),int(b),int(c)
except:
    print('Not number')
    quit()
if isValidScore(a,b,c):
    print('Your middle grade is',computeMiddleGrade(a,b,c))
else:
    print('Not valid score.')