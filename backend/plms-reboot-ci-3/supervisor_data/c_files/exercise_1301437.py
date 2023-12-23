n = input('Please enter a positive integer value: ')
n = int(n)

for i in range(n):
    line = ""
    for j in range(n - i - 1):
        line += " "
    line += "/"
    for j in range(2 * i):
        line += " "
    line += "\\"
    print(line)

for i in range(n):
    line = ""
    for j in range(i):
        line += " "
    line += "\\"
    for j in range(2 * (n - i - 1)):
        line += " "
    line += "/"
    print(line)
