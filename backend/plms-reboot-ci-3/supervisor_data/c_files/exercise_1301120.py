print("*** Fun with Drawing ***")
n = int(input("Enter input : "))
for i in range(2 * n - 1):
    for j in range(i + 1):
        print('#' if (j % 2) == 0 else '.', end='')
    for j in range(4 * n - 2 * i - 4):
        print('#' if (i % 2) == 0 else '.', end='')
    for j in range(i):
        print('#' if ((i - j) % 2) == 1 else '.', end='')
    print('')
for i in range(2 * n - 2):
    for j in range(2 * n - i - 2):
        print('#' if (j % 2) == 0 else '.', end='')
    for j in range(2 * i + 1):
        print('#' if (i % 2) == 1 else '.', end='')
    for j in range(2 * n - i - 2):
        print('#' if ((i - j) % 2) == 1 else '.', end='')

    print('')