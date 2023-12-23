def maxIndex( a , i , j ): 
    if i == j: 
        return i 
    k = maxIndex(a, i + 1, j)
    
    if a[i][1] < a[k][1]:
        value=i
    else:
        value=k
        if a[i][1] == a[k][1]:
            if a[i][2] < a[k][2]:
                value=i
    return value 

def recurSelectionSort(a, n, index = 0): 
    if index == n: 
        return -1
    k = maxIndex(a, index, n-1)
    if k != n-1: 
        a[k], a[n-1] = a[n-1], a[k]
        #print("swap",a[k],"<->",a[n-1],":",a)
    recurSelectionSort(a, n-1) 

def premier_sort(data):
    p = []
    for i in data:
        points = i["wins"] * 3 + i["draws"]
        gd = i["scored"] - i["conceded"]
        add = [i["name"], points, gd]
        p.append(add)
    recurSelectionSort(p, len(p))
    results = [[e[0],{"points":e[1]},{"gd":e[2]}] for e in p]
    print("== results ==")
    print("\n".join(str(e) for e in results))
    

data = input("Enter Input : ").split("/")
for i in range(len(data)):
    b={}
    a=data[i].split(",")
    b["name"] = a[0]
    b["wins"] = int(a[1])
    b["loss"] = int(a[2])
    b["draws"] = int(a[3])
    b["scored"] = int(a[4])
    b["conceded"] = int(a[5])
    data[i] = b
#print("data =",data)
premier_sort(data)