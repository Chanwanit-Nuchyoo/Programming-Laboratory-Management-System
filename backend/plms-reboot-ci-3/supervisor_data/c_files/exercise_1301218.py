def bi_search(l, r, arr, x):
    if l > r:
        return False
    m = int((l + r) / 2)
    if arr[m] == x:
        return True
    return bi_search(m + 1, r, arr, x) if arr[m] < x else bi_search(l, m - 1, arr, x)

inp = input('Enter Input : ').split('/')
arr, k = list(map(int, inp[0].split())), int(inp[1])
print(bi_search( 0, len(arr) - 1, sorted(arr), k))