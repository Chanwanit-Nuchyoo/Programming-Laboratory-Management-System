def factorial(n):
    if n < 2:
        return str(n)
    else:
        return factorial(n-1) + "*" + str(n)

print(" *** Factorial ***")
n = int(input("Enter an integer(n) : "))
result = factorial(n)
print(f"Fac({n}) => {result} = {eval(result)}   ")
