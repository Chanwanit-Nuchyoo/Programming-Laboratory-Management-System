# Check all even numbers.
def even_check(num1):
    num = num1.split()
    even_num = 0
    mul = 1
    
    for n in num:
        mul *= int(n)
        if int(n)%2 == 0:
            continue
        else:
            even_num += 1
    if even_num == 0:
        return (True,mul)
    else:
        return (False,mul)

print("*** Check all even numbers. ***")
nums = input('Enter sequence of numbers: ')
is_even,mul = even_check(nums)
if is_even:
    print("\nAll numbers are even numbers.")
else:
    print("\nAll numbers are not even numbers.")
print("The product of all numbers = %d" %mul)
            