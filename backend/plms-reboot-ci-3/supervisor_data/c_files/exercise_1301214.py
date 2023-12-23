inp = [int(i) for i in input('Enter Input : ').split()]
tmp = inp.copy()
for i in range(len(tmp)):
    for j in range(i+1,len(tmp)):
        if tmp[j] < tmp[i]:
            tmp[i], tmp[j] = tmp[j], tmp[i]
print("Yes" if inp == tmp else "No")