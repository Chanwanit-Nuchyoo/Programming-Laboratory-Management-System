print(" *** Factorial ***")
num = int(input("Enter an integer(n) : "))
fac = 1 
count = 1
print("Fac(%d) => "%num,end="")
while count<num: 
    print(count,end="")
    print("*",end="")
    fac *= count
    count+= 1 
print(count,end="")
print(" = ",end="")
print(fac*count)