def factorial(num):
    fac = 1
    for i in range(num):
        if (i == num-1):
            print(f'{i+1} = ',end="")
        else:
            print(f'{i+1} x ',end="")
        fac *= i+1
    return fac
print(" ***  Factorial ***")
num = int(input("Enter a number : "))
result = factorial(num)
print(f'{result}')