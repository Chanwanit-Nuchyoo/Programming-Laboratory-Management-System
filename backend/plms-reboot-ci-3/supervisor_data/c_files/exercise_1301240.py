def find_pow(tree, n):
    if n >= len(tree):
        return 0
    return tree[n] + find_pow(tree, 2 * n + 1) + find_pow(tree, 2 * n + 2)

inp = input('Enter Input : ').split('/')
tree = [int(i) for i in inp[0].split()]
print(sum(tree))
for i in inp[1].split(','):
    l, r = i.split()
    a, b = find_pow(tree, int(l)), find_pow(tree, int(r))
    if a > b:
        print("{0}>{1}".format(l, r))
    elif a < b:
        print("{0}<{1}".format(l, r))
    elif a == b:
        print("{0}={1}".format(l, r))