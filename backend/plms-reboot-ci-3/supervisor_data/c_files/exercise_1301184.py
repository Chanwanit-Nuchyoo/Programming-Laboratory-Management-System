class node:
    def __init__(self,data,next = None ):
        self.data = data
        self.next = next
    def __str__(self):
        return str(self.data)

def createList(l=[]):
    if l == [] :
        return node(None)
    else:
        h = node(l[0])
        t = h 
        for i in range(1,len(l)):
            t.next = node(l[i])
            t = t.next
        return h
def printList(L):
    s = ''
    tt = L
    while tt != None :
        #print(tt)
        s += str(tt) +' '
        tt = tt.next
    print(s)

def mergeOrderesList(p,q):
    h = p if p.data < q.data else q
    t_p = p.next if p.data < q.data else p
    t_q = q if p.data < q.data else q.next
    #print(h)
    #print(t_p,t_q)
    #print(t_p.next,t_q.next)
    t = h
    while t_p != None and t_q != None :
        if t_p.data < t_q.data :
            t.next = t_p
            t_p = t_p.next
        else:
            t.next = t_q
            t_q = t_q.next
        t = t.next
    #printList(h)
    if t_p == None:
        t.next = t_q
    else:
        t.next = t_p
    return h

#################### FIX comand ####################   
# input only a number 
in1,in2 = input("Enter 2 Lists : ").split(' ')
in1 = in1.split(',')
in2 = in2.split(',')
L1,L2 = [],[]
for i in in1:
    L1.append(int(i))
for i in in2:
    L2.append(int(i))
LL1 = createList(L1)
LL2 = createList(L2)
print('LL1 : ',end='')
printList(LL1)
print('LL2 : ',end='')
printList(LL2)
m = mergeOrderesList(LL1,LL2) # can swap LL1 and LL2 to check the result it's should be the same
print('Merge Result : ',end='')
printList(m)