n = int(input('Enter Input : '))
for i in range(n + 2):
    for j in range(n + 1 - i):
        print('.', end='')
    for j in range(i + 1):
        print('#', end='')
    for j in range(n + 2):
        print('+' if (i == 0) or (i == n + 1) or (j == 0) or (j == n + 1) else '#', end='')
    print('')
for i in range(n + 2):
    for j in range(n + 2):
        print('#' if (i == 0) or (i == n + 1) or (j == 0) or (j == n + 1) else '+', end='')
    for j in range(n - i + 2):
        print('+', end='')
    for j in range(i):
        print('.', end='')
    print('')