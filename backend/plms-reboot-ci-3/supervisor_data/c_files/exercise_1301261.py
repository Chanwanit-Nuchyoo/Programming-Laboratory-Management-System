inp = input('Enter Input : ').split('/')
arr, k = list(map(int, inp[0].split())), int(inp[1])
l, r, ans = max(arr), sum(arr), sum(arr)
while l <= r:
    m = int((l + r) / 2)
    cnt, box = 0, 1
    for i in arr:
        if cnt + i > m:
            box +=1
            cnt = 0
        cnt += i
    if box > k:
        l = m + 1
    else:
        ans = min(ans, m)
        r = m - 1
print('Minimum weigth for {0} box(es) = {1}'.format(k, ans))