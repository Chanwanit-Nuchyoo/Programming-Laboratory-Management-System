def findmin(n):
    if len(n) == 1:
        return n[0]
    tmp = findmin(n[:-1])
    return n[-1] if n[-1] < tmp else tmp
inp = [int(i) for i in input('Enter Input : ').split()]
print("Min :", findmin(inp))