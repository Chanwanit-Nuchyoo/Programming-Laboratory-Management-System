members = {}
data_list = input("Enter age and name : ").split()
print(data_list)
for i in range(int(len(data_list)/2)):
    key = data_list[i*2+1]
    value = int(data_list[i*2])
    members[key] = value
print(members)



print("*** The Histogram of Age ***")
for x in members:
    print(x[:3], end=' : ')
    #print(members[x])
    for i in range(members[x]):
        print("=", end='')
    print(i+1, end='')
    print()