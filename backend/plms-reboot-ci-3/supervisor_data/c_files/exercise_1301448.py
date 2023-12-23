n = int(input("Plese enter number: "))
if n%2 == 0:
    print("Please enter odd number only.")
    exit()
for i in range(n):
    for j in range(n):
        if (i==j) or (i+j == n-1):
            print(i+1, end='')
        else:
            if i==0 or i==n-1:
                print(i+1, end='')
            else:
                print(' ', end='')
    print()