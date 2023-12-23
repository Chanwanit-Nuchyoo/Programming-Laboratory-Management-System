print(" *** even integer summation from 1 to n ***")
num = int(input("Enter an integer(n) : "))
sum = 0 
count = 2
if num%2==1:
    num = num-1
print("Summation => ",end="")
while count<num: 
    print(count,end="")
    print("+",end="")
    sum += count
    count+= 2 
print(count,end="")
print(" = ",end="")
print(sum+count)