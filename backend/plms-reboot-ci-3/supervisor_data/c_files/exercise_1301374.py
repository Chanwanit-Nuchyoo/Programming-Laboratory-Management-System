args = input('Enter 2 integer values: ')
arg1, arg2 = args.strip().split()
total = int(arg1) + int(arg2)
if total < 0:
    print('The answer is negative')
elif total % 2 == 0:
    print('Total =', total)
else:
    print('It is odd!')
