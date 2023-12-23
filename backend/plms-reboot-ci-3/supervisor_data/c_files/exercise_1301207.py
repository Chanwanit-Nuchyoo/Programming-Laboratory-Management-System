def perket(a, b, x, y, n):
    if n == len(a):
        if x != 1 and y != 0:
            calculate(x, y)
    else:
        x *= a[n]
        y += b[n]
        perket(a, b, x, y, n + 1)
        x //= a[n]
        y -= b[n]
        perket(a, b, x, y, n + 1)

def calculate(x, y):
    global MIN
    if MIN > abs(x - y):
        MIN = abs(x - y)
        
MIN = 1000000001
inp = input('Enter Input : ').split(',')
bitter, sour = [0] * len(inp), [0] * len(inp)
for i in range(len(inp)):
    tmp = inp[i].split(' ')
    sour[i], bitter[i] = int(tmp[0]), int(tmp[1])
perket(sour, bitter, 1, 0, 0)
print(MIN)