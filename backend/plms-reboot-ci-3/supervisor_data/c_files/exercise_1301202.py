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
    
    def reverse(self):
        # work
        prev = None
        current = self.head
        while(current is not None):
            current = self.head.next
            self.head.next = prev
            prev = self.head
            self.head = current
        self.head = prev
    
    def removeDup(self) :
        seen = set()
        i = 0
        p = self.head
        while p != None :
            if p.data not in seen :
                seen.add(p.data)
            else :
                self.deleteAfter(i-1)
                i -= 1
            i += 1
            p = p.next
    
    def deleteAfter(self, i):
        q = self.nodeAt(i)
        q.next = q.next.next
        
    def nodeAt(self, i):
        p = self.head
        for j in range(i):
            p = p.next
        return p


inputlist = [int(e) for e in input('Enter numbers : ').split()]
ll = LinkedList()
for e in inputlist:
    ll.append(e)
print("Linkedlist Before removeDuplicate")
print(ll)
print("Linkedlist After removeDuplicate")
ll.removeDup()
print(ll)

# 3 5 7 9 11 7 5 20
# 3 3 7 7 7 8 4 20 20
# 10 222 353 20 222 1
# 100 
# 45 -8 0 8 -8 7 4 2 3 1 2