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
    
    def contentEquivalence(self, list2):
        if len(self) != len(list2):
            return False
        temp = []
        p = self.head
        while p is not None:
            temp.append(p.data)
            p = p.next
        p = list2.head
        while p is not None:
            if p.data in temp:
                temp.remove(p.data)
                p = p.next
            else:
                return False
        return True
    
    
rawinput = input('List1,List2 : ').split(',')
l1 = LinkedList()
for e in rawinput[0].split():
    l1.append(e)
l2 = LinkedList()
for e in rawinput[1].split():
    l2.append(e)

print("List1 content Equivalence List2 :",l1.contentEquivalence(l2))

#0 l1  a b c         l2  a b c d 
#1 l1  a b c d e     l2  e d c b a
#2 l1  e d c b a     l2  a b c d e    
#3 l1  a b c d e     l2  a b c d e
#4 l1 a b c d e      l2  d d c b a 
#5 l1  a b c d d     l2  a b c d e 
#6 l1 a b c d        l2  d d c b a
#7 l1 a a a a a      l2 d d c b a
#8 l1 a b c d e      l2  a a a a a 
#9 l1 a b c d d      l2  e d c b a 
#10 l1 a b c d       l2 e d c b a 
#11 l1 a b c d e     l2 e d c b 













#####################
 
 
'''
l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('e')
l2 = LinkedList()
l2.append('e')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase1 Content Equivalence1", l1.contentEquivalance(l2))
#1 l1  a b c d e      l2 e d c b a

l1 = LinkedList()
l1.append('e')
l1.append('d')
l1.append('c')
l1.append('b')
l1.append('a')
l2 = LinkedList()
l2.append('a')
l2.append('b')
l2.append('c')
l2.append('d')
l2.append('e')
print("\ncase11 Content Equivalence1", l1.contentEquivalance(l2))
#2 l1 e d c b a   l2  a b c d e

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('e')
l2 = LinkedList()
l2.append('a')
l2.append('b')
l2.append('c')
l2.append('d')
l2.append('e')
print("\ncase111 Content Equivalence1", l1.contentEquivalance(l2))
#3 l1  a b c d e    l2  a b c d e

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('e')
l2 = LinkedList()
l2.append('d')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase2 Content Equivalence1", l1.contentEquivalance(l2))
#4  l1 a b c d e     l2  d d c b a 

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('d')
l2 = LinkedList()
l2.append('a')
l2.append('b')
l2.append('c')
l2.append('d')
l2.append('e')
print("\ncase22 Content Equivalence1", l1.contentEquivalance(l2))
#5  l1  a b c d d      l2  a b c d e 

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l2 = LinkedList()
l2.append('d')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase3 Content Equivalence1", l1.contentEquivalance(l2))
#6 l1 a b c d      l2  d d c b a

l1 = LinkedList()
l1.append('a')
l1.append('a')
l1.append('a')
l1.append('a')
l1.append('a')
l2 = LinkedList()
l2.append('d')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase4 Content Equivalence1", l1.contentEquivalance(l2))
#7 l1 a a a a a       l2 d d c b a

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('e')
l2 = LinkedList()
l2.append('a')
l2.append('a')
l2.append('a')
l2.append('a')
l2.append('a')
print("\ncase5 Content Equivalence1", l1.contentEquivalance(l2))
#8  l1 a b c d e   l2  a a a a a 


l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('d')
l2 = LinkedList()
l2.append('e')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase6 Content Equivalence1", l1.contentEquivalance(l2))
#9 l1 a b c d d    l2  e d c b a 

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l2 = LinkedList()
l2.append('e')
l2.append('d')
l2.append('c')
l2.append('b')
l2.append('a')
print("\ncase6 Content Equivalence1", l1.contentEquivalance(l2))
#10 l1 a b c d   l2 e d c b a 

l1 = LinkedList()
l1.append('a')
l1.append('b')
l1.append('c')
l1.append('d')
l1.append('e')
l2 = LinkedList()
l2.append('e')
l2.append('d')
l2.append('c')
l2.append('b')
print("\ncase7 Content Equivalence1", l1.contentEquivalance(l2))
#11 l1 a b c d e     l2 e d c b 



#l1 = List()
#l1.append1('a')
#l1.append1('b')
#l1.append1('c')
#l1.append1('d')
#l1.append1('e')
#print(l1)
'''