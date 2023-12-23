def RANGE(*args):
    if len(args) == 1:
        a, b, c = 0.0, args[0], 1.0
    elif len(args) == 2:
        a, b, c = args[0], args[1], 1.0
    elif len(args) == 3:
        a, b, c = args[0], args[1], args[2]
    ans = str(round(a, 3))
    while (a + c) < b:
        a += c
        ans += " " + str(round(a, 3))
    return tuple([float(i) for i in ans.split()])

print('*** New Range ***')
n = [float(i) for i in input('Enter Input : ').split()]
if len(n) == 1:
    k = RANGE(n[0])
    print(RANGE(n[0]))
elif len(n) == 2:
    print(RANGE(n[0], n[1]))
elif len(n) == 3:
    print(RANGE(n[0], n[1], n[2]))