n = int(input("Plese enter number: "))
if n <= 0:
    print("Please enter number greater than zero.")
    exit()
for row in range(n):
    for i in range(row):
        print(row, end="")
    for i in range(2*(n-row)-1):
        print(" ", end="")
    for i in range(row):
        print(row, end="")
    print()
for row in range(n*2-1):
    print(n, end="")
print()
for row in reversed(range(n)):
    for i in range(row):
        print(row, end="")
    for i in range(2*(n-row)-1):
        print(" ", end="")
    for i in range(row):
        print(row, end="")
    print()