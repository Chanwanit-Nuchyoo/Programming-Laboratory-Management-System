def dfs(start, end, k, topo, mark, path):
    if k[-1] == end:
        if len(k) == len(set(k)):
            path.append(k[:])
    for i in range(len(topo[start - 1])):
        if mark[topo[start - 1][i] - 1] == 0:
            mark[topo[start - 1][i] - 1] = 1
            k.append(topo[start - 1][i])
            dfs(topo[start - 1][i], end, k, topo, mark, path)
            k.pop()
            mark[topo[start - 1][i] - 1] = 0

topo, path = [], []
inp = input('Enter Input : ').split('/')
for i in inp[0].split(','):
    a, b = map(int, i.split())
    if max(a, b) > len(topo):
        tmp = max(a, b) - len(topo)
        for j in range(tmp):
            topo.append([])
    topo[a-1].append(b)
    topo[b-1].append(a)

x, y = map(int, inp[1].split())
dfs(x, y, [x], topo, [0] * len(topo), path)
if len(path) == 0:
    print('{0} can\'t go to {1}'.format(x, y))
else:
    print('All possible path from {0} to {1} :'.format(x, y))
    for i in sorted(path, key = lambda x: len(x)):
        print(' -> '.join(list(map(str, i))))