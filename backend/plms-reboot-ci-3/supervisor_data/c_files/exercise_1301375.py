args = input('Enter 3 integer values: ')
arg1, arg2, arg3 = args.strip().split()
val1 = int(arg1)
val2 = int(arg2)
val3 = int(arg3)
if val1 == val2 == val3:
    text = 'All the numbers are equal'
elif val1 < val2 < val3:
    text = 'Ascending ordered data'
else:
    text = 'Unable to determine the order'
print(text)
