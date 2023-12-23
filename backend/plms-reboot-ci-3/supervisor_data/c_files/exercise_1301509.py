print(" *** Sum of even digit ***")
num = int(input("Enter an integer : "))
count = 0 
sum = 0
while num != 0: 
    if num%2==0:
        sum += num%10
    num //= 10 
    count+= 1 
    
print("Total digits = ", count)
print(f'Sum of even numbers = {sum}')