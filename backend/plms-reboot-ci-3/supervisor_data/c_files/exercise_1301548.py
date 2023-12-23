# Check numbers that are divisible by 5 and 7.
def divisible(num1):
    num = num1.split()
    sum = 0
    is_div = 0           
    for n in num:
        sum += int(n)
        if int(n)%5 == 0 and int(n)%7 == 0:
            continue
        else:
            is_div += 1
    if is_div == 0:
        return (True,sum)
    else:
        return (False,sum)
   
print("*** Check all numbers that are divisible by 5 and 7. ***")
nums = input('Enter a sequence of number: ')
is_divisible,sum = divisible(nums)
if is_divisible:
    print("\nAll numbers are divisible.")
else:
    print("\nAll numbers are not divisible.")
print("Sum of all numbers = %d" %sum)
      