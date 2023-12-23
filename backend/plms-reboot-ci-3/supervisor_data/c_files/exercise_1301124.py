def sortList(a,n,i=0,j=0):
    if j == n:
        i = i+1
        j = 0
    if i == n:
        return 
    if a[i] > a[j]:
        temp = a[j]
        a[j] = a[i]
        a[i] = temp
        sortList(a,n,i, j+1)
    else:
        sortList(a,n, i, j + 1)
    return a
pp = input("Enter your List : ").split(',')
for i in range(len(pp)) :
    pp[i] = int(pp[i])
print("List after Sorted :",sortList(pp,len(pp)))