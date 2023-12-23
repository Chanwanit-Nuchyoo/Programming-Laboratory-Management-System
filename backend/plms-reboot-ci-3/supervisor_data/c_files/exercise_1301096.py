def isPrime(n):
    if n <= 1:
        return False
    for i in range(2, n):
        if n % i == 0:
            return False
    return True


def showPrime(x, y):
    rs = []
    for i in range(x if x < y else y, y+1 if y > x else x+1):
        if isPrime(i):
            rs.append(i)
    return rs

print(" ***Prime between 2 number***")
m, n = input("Enter number 2 number : ").split()
a = int(m)
b = int(n)
if a < 0 or b < 0:
    print("Some or Both not positive number!!!")
else:
    ans = showPrime(a, b)
    print("Prime number between", a if a < b else b, "and", b if b > a else a, ": ",end="")
    for i in ans:
        print(i, end=" ")