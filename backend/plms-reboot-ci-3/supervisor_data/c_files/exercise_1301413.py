print(" *** Filter only even number ***")
nums = input('Enter some numbers: ').split()
print(nums)
for n in nums:
    #print(n)
    if int(n)%2 ==0:
        print(n+" ",end="")
print()