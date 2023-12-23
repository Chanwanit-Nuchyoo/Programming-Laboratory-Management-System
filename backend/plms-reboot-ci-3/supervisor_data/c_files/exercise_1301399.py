number = int(input("Enter a1a2a3a4a5a6a7a8a9a10a11a12 : "))

a1  = (number%1000000000000)//100000000000
a2  = (number%100000000000)//10000000000
a3  = (number%10000000000)//1000000000
a4  = (number%1000000000)//100000000
a5  = (number%100000000)//10000000
a6  = (number%10000000)//1000000
a7  = (number%1000000)//100000
a8  = (number%100000)//10000
a9  = (number%10000)//1000
a10 = (number%1000)//100
a11 = (number%100)//10
a12 = number%10

a13 = (10 - (a1 + 3*a2 + a3 + 3*a4 + a5 + 3*a6 + a7 + 3*a8 + a9 + 3*a10 + a11 + 3*a12))%10

check = a1 + 3*a2 + a3 + 3*a4 + a5 + 3*a6 + a7 + 3*a8 + a9 + 3*a10 + a11 + 3*a12 + a13

print('---Calculate ISBN---')
print('  ISBN = %d%d%d%d%d%d%d%d%d%d%d%d%d' %(a1, a2, a3, a4, a5, a6, a7, a8, a9, a10, a11, a12, a13))

print('---Check ISBN---')
print(' check = %d' %check)