n = int(input("Plese enter number: "))
if n <= 0:
    print("Please enter number greater than zero.")
    exit()
for row in range(n):
    for i in range(row):
        print(" ", end="")
    for i in range(2*(n-row)-1):
        print(row+1, end="")
    for i in range(row):
        print(" ", end="")
    print()
for row in reversed(range(n-1)):
    for i in range(row):
        print(" ", end="")
    for i in range(2*(n-row)-1):
        print(row+1, end="")
    for i in range(row):
        print(" ", end="")
    print()