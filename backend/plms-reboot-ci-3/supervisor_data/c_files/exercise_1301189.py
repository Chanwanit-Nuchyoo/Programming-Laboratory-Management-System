def findmax(n):
    if len(n) == 1:
        return n[0]
    tmp = findmax(n[:-1])
    return n[-1] if n[-1] > tmp else tmp
inp = [int(i) for i in input('Enter Input : ').split()]
print("Max :", findmax(inp))