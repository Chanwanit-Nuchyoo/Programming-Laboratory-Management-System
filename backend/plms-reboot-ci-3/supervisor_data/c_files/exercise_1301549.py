# Check numbers that are divisible by 3 and 5.
def divisible(num1):
    num = num1.split()
    mul = 1
    is_div = 0       
        
    for n in num:
        mul *= int(n)
        if int(n)%3 == 0 and int(n)%5 == 0:
            continue
        else:
            is_div += 1
    if is_div == 0:
        return (True,mul)
    else:
        return (False,mul)
    

print("*** Check all numbers that are divisible by 3 and 5. ***")
nums = input('Enter a sequence of number: ')
is_divisible,mul = divisible(nums)
if is_divisible:
    print("\nAll numbers are divisible.")
else:
    print("\nAll numbers are not divisible.")
print("The product of all numbers = %d" %mul)
