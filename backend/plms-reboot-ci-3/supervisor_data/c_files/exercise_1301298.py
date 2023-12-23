def sumofthreeelementinarray(n):
    if len(n) >= 3:
        list = sorted(n)
        result = []
        i = 0
        while i < len(list)-2:
            j,k = i+1 ,len(list)-1
            while j < k :
                if list[i] + list[j] + list[k] < 5:
                    j += 1
                elif list[i] + list[j] + list[k] > 5:
                    k -= 1
                else:
                    result.append([list[i],list[j],list[k]])
                    j,k = j + 1 ,k -1
                    while j < k and list[j] == list[j-1]:
                        j += 1
                    while j < k and  list[k] == list[k+1]:
                        k -= 1
            i += 1
            while i < len(list) -2 and list[i] == list [i-1]:
                i += 1
        return  result
    else :
        return "Array Input Length Must More Than 2"

list = [-25,-10,-7,-3,2,4,8,10]
n = input("Enter Your List : ").split()
for i in range(len(n)) :
     n[i] = int(n[i])

print(sumofthreeelementinarray(n))