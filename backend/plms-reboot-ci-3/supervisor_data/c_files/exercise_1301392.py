args = input('Please enter 2 integer values: ')
arg1, arg2 = args.strip().split()
val1 = int(arg1)
val2 = int(arg2)
if val1 < 1 or val2 < 1:
    print('Only positive values are allowed')
elif val1 >= val2:
    print('Answer =', val1 + val2)
else:
    print('Answer =', val1 * 2 - val2)
