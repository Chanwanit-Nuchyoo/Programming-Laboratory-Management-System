print("*** Fun with Drawing ***")
n = int(input("Enter input : "))
for i in range(n):
    for j in range(n - i - 1):
        print('.', end='')
    print('*', end='')
    for j in range(i):
        print('+', end='')
    for j in range(i - 1):
        print('+', end='')
    if i : print('*', end='')
    for j in range(n - i - 1):
        print('.', end='')
    for j in range(n - i - 2):
        print('.', end='')
    if i != (n - 1) : print('*', end='')
    for j in range(i):
        print('+', end='')
    for j in range(i - 1):
        print('+', end='')
    if i : print('*', end='')
    for j in range(n - i - 1):
        print('.', end='')
    print('')
for i in range(2 * n - 2):
    for j in range(i + 1):
        print('.', end='')
    print('*', end='')
    for j in range(2 * n - i - 3):
        print('+', end='')
    for j in range(2 * n - i - 4):
        print('+', end='')
    if i != (2 * n - 3) : print('*', end='')
    for j in range(i + 1):
        print('.', end='')
    print('')