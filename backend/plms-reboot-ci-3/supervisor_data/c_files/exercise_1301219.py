def first_greater_value(l, r, arr, x):
    ans, int_max = 999999999, 999999999
    while l <= r:
        m = int((l + r) / 2)
        if arr[m] <= x:
            l = m + 1
        else:
            ans = min(arr[m], ans)
            r = m - 1
    return ans if min(ans, int_max) != int_max else "No First Greater Value"

inp = input('Enter Input : ').split('/')
arr, k = list(map(int, inp[0].split())), list(map(int, inp[1].split()))
tmp = sorted(arr)
for i in k:
    print(first_greater_value(0, len(arr) - 1, tmp, i))