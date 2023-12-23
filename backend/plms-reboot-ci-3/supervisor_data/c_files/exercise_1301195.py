def knapsack(k, n, arr, path):
    pattern = 0
    if n == len(arr):
        if sum(path) == k:
            print(' '.join(str(i) for i in path))
            return 1
    else:
        path.append(arr[n])
        pattern += knapsack(k, n + 1, arr, path)
        path.pop()
        pattern += knapsack(k, n + 1, arr, path)
        return pattern
    return pattern

inp = input('Enter Input (Money, Product) : ').split('/')
arr = [int(i) for i in inp[1].split()]
pattern = knapsack(int(inp[0]), 0, arr, [])
print("Krisada can purchase Product: {0} with: {1} Baht | {2} Pattern".format(arr, inp[0], pattern))