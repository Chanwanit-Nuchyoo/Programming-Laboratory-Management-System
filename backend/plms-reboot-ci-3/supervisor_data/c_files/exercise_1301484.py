members = {}
data_list = input("Enter name and weight : ").split()
print(data_list)
for i in range(int(len(data_list)/2)):
    key = data_list[i*2]
    value = int(data_list[i*2+1])
    members[key] = value
print(members)

tmp = list()
for k, v in members.items():
    tmp.append((v, k))
print(tmp)
tmp = sorted(tmp)
print(tmp)


print("*** The Histogram of Weight ***")
for v, k in tmp:
    print(k[:3], end=' : ')
    for i in range(v):
        print("=", end='')
    print(v, end='')
    print()