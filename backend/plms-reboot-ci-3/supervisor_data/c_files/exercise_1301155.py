print(" *** Sum of x Factor, less than or equal n **")
str = input("Enter x n : ")
x,n = str.split()
x = int(x)
n = int(n)
sum = 0
count = 0
for i in range(n):
    test = n-i
    if(test%x==0):
        count += 1
        if test<=x:
            print(f'{test} = ', end='')
        else:
            print(test,'+',end=' ')
        sum += test
print(f'{sum}')
print(f'Total = {count}')