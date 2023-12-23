# Return minimum index 
def insert(l,data,i):
    if i==len(l):
        if l[i-1]<data:
            print("insert",data,"at index",len(l),end=" : ")
            l.append(data)
            return l
        else:
            return insert(l,data,i-1)
    elif i>0:
        if l[i-1]>data:
            return insert(l,data,i-1)
    print("insert",data,"at index",i,end=" : ")
    l.insert(i,data)
    return l

def insertion_sort(l,n):
    if n>=len(l):
        print("sorted")
        return l
    elif n<len(l):
        a = l[:n]
        a = insert(a,l[n],len(a))
        l = a+l[n+1:]
        print(a,l[n+1:] if l[n+1:]!=[] else "")
        return insertion_sort(l,n+1)
    else:
        return l
      
l = [int(e) for e in input("Enter Input : ").split()]
# Calling function 
l = insertion_sort(l, 1) 
  
# printing sorted array 
print(l)