def mod_position(arr, s):
    ans = []
    for i in range(len(arr)):
        if (i+1)%s == 0:
            ans.append(arr[i])
    return ans

print("*** Mod Position ***")
s = input('Enter Input : ').split(',')
print(mod_position(s[0],int(s[1])))