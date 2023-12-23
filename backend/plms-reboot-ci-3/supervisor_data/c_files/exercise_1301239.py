inp = input('Enter Input : ').split('/')
tree, values = [-1] * int(inp[0]), [int(i) for i in inp[1].split()]
if len(values) != int(inp[0]) // 2 + 1:
    print("Incorrect Input")
else:
    for i in range(len(tree) - len(values), len(tree)):
        tree[i] = values[i - len(values) + 1]
    for i in range(len(tree) - 2, 0, -2):
        tmp = min(tree[i], tree[i + 1])
        tree[i], tree[i + 1], tree[i // 2] = tree[i] - tmp, tree[i + 1] - tmp, tmp
    print(sum(tree))