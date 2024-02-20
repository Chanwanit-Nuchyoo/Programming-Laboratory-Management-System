def factorial(n):
    if n < 2:
        return str(n)
    else:
        return str(n) + "*" + factorial(n-1)

print(" *** Factorial ***")
n = int(input("Enter an integerrrr(n) : "))
result = factorial(n)
print(f"Fac({n}) => {result} = {eval(result)}")
