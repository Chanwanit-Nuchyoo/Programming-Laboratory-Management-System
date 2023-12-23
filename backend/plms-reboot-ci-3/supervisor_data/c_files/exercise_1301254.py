def bubble_r(l):
    if len(l)==1:
        return l
    elif len(l)>1:
        l=sort(l,0)
        ll=bubble_r(l[:-1])
        return ll+l[len(ll):]
def sort(l,i):
    if i<len(l)-1:
        if l[i] > l[i+1]:
            l[i], l[i+1] = l[i+1], l[i]
        return sort(l,i+1)
    return l
l = [int(e) for e in input("Enter Input : ").split()]
print(bubble_r(l))