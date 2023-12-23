date, add_day1, add_day2 = input("Enter date add_day : ").split()

dd   = (int(date)%1000000000)//1000000
mm   = (int(date)%1000000)//10000
yyyy = (int(date)%10000)

dd_new   = (dd + int(add_day1) + int(add_day2))%30
quotient = (dd + int(add_day1) + int(add_day2))//30

mm_new   = (mm + quotient)%12
quotient = (mm + quotient)//12

yyyy_new = yyyy + quotient

print('---Date---')
print('dd   = %d' %dd)
print('mm   = %d' %mm)
print('yyyy = %d' %yyyy)

print('---New Date---')
print('dd   = %d' %dd_new)
print('mm   = %d' %mm_new)
print('yyyy = %d' %yyyy_new)


