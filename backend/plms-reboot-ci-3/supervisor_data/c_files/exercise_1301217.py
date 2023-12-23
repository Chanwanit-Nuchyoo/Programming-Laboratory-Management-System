def get_subsets(end, n, lst, tmp, answer):
    if end == n:
        if sum(tmp) == answer:
            global ans
            for i in range(len(ans)):
                if len(ans[i]) > len(tmp):
                    ans.insert(i, tmp[:])
                    break
            else:
                ans.append(tmp[:])
    else:
        tmp.append(lst[n])
        get_subsets(end, n + 1, lst, tmp, answer)
        tmp.pop()
        get_subsets(end, n + 1, lst, tmp, answer)
    
inp = input('Enter Input : ').split('/')
arr, k = list(map(int, inp[1].split())), int(inp[0])
for i in range(len(arr)):
    for j in range(i+1, len(arr)):
        if arr[j] < arr[i]:
            arr[i], arr[j] = arr[j], arr[i]
ans = []
get_subsets(len(arr), 0, arr, [], k)
if len(ans) == 0:
    print("No Subset")
else:
    for i in ans:
        print(i)