print(" *** odd integer summation from 1 to n ***")
num = int(input("Enter an integer(n) : "))
if num%2==0:
    num = num-1
sum = 0 
count = 1
print("Summation => ",end="")
while count<num: 
    print(count,end="")
    print("+",end="")
    sum += count
    count+= 2 
print(count,end="")
print(" = ",end="")
print(sum+count)