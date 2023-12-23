print(" *** Binary to Decimal ***")
binary = input('Enter binary number : ')
decimal = 0
num = len(binary) - 1
for e in binary:
    decimal += int(e)*2**num
    num -= 1
print(f'{binary} ==> {decimal}')