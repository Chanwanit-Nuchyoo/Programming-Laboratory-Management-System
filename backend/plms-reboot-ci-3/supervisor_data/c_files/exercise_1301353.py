print(" *** 3-digit odd even ***")
str = input("Enter 3-digit number : ")
num = int(str)
if (num%10%2==0): 
    unit = "even"
else :
    unit = "odd"
if (num//10%2==0):
    tenth = "even"
else :
    tenth = "odd"
if (num//100%2==0):
    hundredth = "even"
else :
    hundredth = "odd"
print("{0} => {1} {2} {3}".format(num,hundredth,tenth,unit))