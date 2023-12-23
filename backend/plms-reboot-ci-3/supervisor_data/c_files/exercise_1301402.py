def isValidWeightHeight(a,b):
    if a <= 0 or a >= 200 :
        return False
    elif b <= 0 or b >= 300 :
        return False
    else:
        return True

def bmiCalculator(a,b) :
    x = a / ((b/100)*(b/100))
    if x >= 23.0:
        return "overweight"
    elif x >= 18.5 and x < 23.0:
        return "normal"
    else:
        return "underweight"

a,b = input("Enter weight(kg) and height(cm): ").split()
try:
    a,b = float(a),float(b)
except:
    print('Not number')
    quit()
if isValidWeightHeight(a,b):
    print('You are',bmiCalculator(a,b))
else:
    print('Not valid weight or height.')