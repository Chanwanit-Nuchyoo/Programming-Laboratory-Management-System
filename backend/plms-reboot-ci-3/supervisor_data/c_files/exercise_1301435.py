n = int(input("Plese enter number: "))
if n%2 == 0:
    print("Please enter odd number only.")
    exit()
for i in range(n):
    for j in range(n):
        if (j == abs(int(n/2)-i)) or (j == n-1-abs(int(n/2)-i)):
            print(i+1, end='')
        else:
            print('-', end='')
    print()