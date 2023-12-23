def Asc(lst):
    for i in range(len(lst)):
        for j in range(i+1,len(lst)):
            if lst[i] > lst[j]:
                lst[i], lst[j] = lst[j], lst[i]
    return lst

def Des(lst):
    for i in range(len(lst)):
        for j in range(i+1,len(lst)):
            if lst[i] < lst[j]:
                lst[i], lst[j] = lst[j], lst[i]
    return lst

inp = list(map(int, list(input('Enter Input : '))))
asc = Asc(inp.copy())
des = Des(inp.copy())
if len(set(inp)) == 1:
    print("Repdrome")
elif inp == asc:
    print("Metadrome" if len(inp) == len(set(inp)) else "Plaindrome")
elif inp == des:
    print("Katadrome" if len(inp) == len(set(inp)) else "Nialpdrome")
else:
    print("Nondrome")