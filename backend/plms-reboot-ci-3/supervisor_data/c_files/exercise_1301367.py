print(" *** digit count ***")
num = int(input("Enter an integer : "))
count = 0 
while num != 0: 
    num //= 10 
    count+= 1 
print("Total digits are: ", count)