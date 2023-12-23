args = input('Please enter working hours and pay rate per hour: ')
arg1, arg2 = args.strip().split()
hours = float(arg1)
rate = float(arg2)
ot = 0
if hours > 8:
    ot = hours - 8
    hours = 8
wage = (hours * rate) + (ot * rate * 1.5)
print('Wage =', int(wage))
