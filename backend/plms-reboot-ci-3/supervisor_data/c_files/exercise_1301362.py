def absolute(num) :
    try:
        num = float(num)
    except:
        return "Not valid input !!!"
    if int(num)==num:
        if num >= 0 :
            return int(num)
        else :
            return int(-num)
    else:
        if num>=0:
            return num
        else:
            return -num

print(" *** Absolute value ***")
numA, numB, numC = input("Input num1 num2 num3 : ").split()
print("Absolute of",numA,"is",absolute(numA))
print("Absolute of",numB,"is",absolute(numB))
print("Absolute of",numC,"is",absolute(numC))