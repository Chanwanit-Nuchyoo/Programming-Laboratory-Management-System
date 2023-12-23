args = input('Please enter 2 integer values: ')
arg1, arg2 = args.strip().split()
val1 = int(arg1)
val2 = int(arg2)
if val1 == val2:
    print('No difference')
elif val1 > val2:
    print('Delta =', val1 - val2)
else:
    print('Delta =', val2 - val1)
