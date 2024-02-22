class LinkedList:
    class Node :
        def __init__(self,data,next = None) :
            self.data = data
            if next is None :
                self.next = None
            else :
                self.next = next
                
        def __str__(self) :
            return str(self.data)

    def __init__(self,head = None):
        if head == None:
                self.head = self.tail = None
                self.size = 0
        else:
            self.head = head
            t = self.head        
            self.size = 1
            while t.next != None :
                t = t.next
                self.size += 1
            self.tail = t
            
    def __str__(self) :
        s = 'Linked data : '
        p = self.head
        while p != None :
            s += str(p.data)+' '
            p = p.next
        return s

    def __len__(self) :
        return self.size
    
    def append(self, data):
        p = self.Node(data)
        if self.head == None:
            self.head = self.tail = p
        else:
            t = self.tail
            t.next = p   
            self.tail =p  
        self.size += 1

    def removeHead(self) :
        if self.head == None : return
        if self.head.next == None :
            p = self.head
            self.head = None
        else :
            p = self.head
            self.head = self.head.next
        self.size -= 1
        return p.data
    
    def isEmpty(self) :
        return self.size == 0
    
    def nodeAt(self,i) :
        p = self.head
        for j in range(i) :
            p = p.next
        return p
    
    def add(self,data) :
        if not self.isEmpty() :
            i = 0
            p = self.head
            for i in range(len(self)) :
                if data > p.data :
                    p = p.next
                    i += 1
                else :
                    self.insertAfter(i-1,data)
                    return
        #print("len(self) :",len(self))
        self.insertAfter(len(self),data)
    
    def insertAfter(self,i,data) :
        p = self.Node(data)
        #print("i",i,data)
        if i == len(self):
            self.append(data)
        elif i == -1 and len(self) == 0: #insert head
            sefl.append(data)   
        elif i == -1 and len(self) > 0:
            p.next = self.head    
            self.head = p
            self.size += 1
        else:
            q = self.nodeAt(i)
            p.next = q.next
            q.next = p
            self.size += 1


def findMean(l) :
    sum = 0
    p = l.head
    for i in range(len(l)) :
        sum += p.data
        p = p.next
    print("Mean = %.2f" % (sum/len(l)))


def findMode(l) :
    f = [0]*len(l)
    count = 0
    countmax = 0
    p = l.head
    for i in range(len(l)) :
        q = l.head.next
        for j in range(len(l)) :
            if p.data == q.data :
                count += 1
            q = q.next
        if count > countmax :
            countmax = count
            mode = p.data
        p = p.next
    return mode

def findMode2(l) :
    d = dict()
    count = 0
    countmax = 0
    p = l.head.next
    for i in range(len(l)-1) :
        if p.data == p.next.data :
            count += 1
            d[p.data] = count
        else : count = 0
        p = p.next

    for v in d.values() :
        if v > countmax : countmax = v
    if countmax > 0 :
    
        print("Mode = ",end=' ')
        for k in d :
            if d[k] == countmax :
                print(k,end=' ')
        print()
    else :
        print("Mode is not available.")

def findMedian(l) :
    if len(l) %2 == 0 :
        p1 = int(l.nodeAt(len(l)//2).data)
        p2 = int(l.nodeAt(len(l)//2-1).data)
        p3 = (p1+p2)/2
        print("Median = %.2f" % p3)
        
    else :
        p = l.nodeAt(len(l)//2).data
        print("Median = %.2f" % p)
        #print("Median = ",p)



inputlist = [int(e) for e in input('Enter numbers : ').split()]
l = LinkedList()
for e in inputlist:
    l.add(e)
    #print(l)

print("Output :")
print(l)
print('Amount of data =',len(l))
findMean(l)
#findMode2(l)
findMedian(l)