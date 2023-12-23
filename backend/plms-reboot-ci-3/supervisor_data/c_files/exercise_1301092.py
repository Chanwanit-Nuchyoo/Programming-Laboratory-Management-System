# Check all odd numbers.
def odd_check(num1):
    num = num1.split()
    odd_num = 0
    sum = 0

    for n in num:
        sum += int(n)
        if int(n)%2 != 0:
            continue
        else:
            odd_num += 1
    if odd_num == 0:
        return (True,sum)
    else:
        return (False,sum)

print("*** Check all odd numbers. ***")
nums = input('Enter sequence of numbers: ')
is_odd,sum = odd_check(nums)
if is_odd:
    print("\nAll numbers are odd.")
else:
    print("\nAll numbers are not odd.")
print("Sum of all numbers = %d" %sum)