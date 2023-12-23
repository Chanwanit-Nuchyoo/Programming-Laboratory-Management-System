class Node:
    def __init__(self, value):
        self.value = value
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def __str__(self):
        s = ""
        cur = self.head
        while cur != None:
            s += cur.value + " "
            cur = cur.next
        return s

    def size(self):
        cur = self.head
        cnt = 0
        while cur != None:
            cur, cnt = cur.next, cnt + 1
        return cnt

    def pop(self):
        cur = self.head.next
        prev = self.head
        if cur == None:
            self.head = None
            return prev
        while cur.next != None:
            prev = cur
            cur = cur.next
        prev.next = cur.next
        cur.next = None
        return cur
        

    def add(self, item):
        if self.head == None:
            self.head = item
        else:
            cur = self.head
            while cur.next != None:
                cur = cur.next
            cur.next = item

L1, L2 = LinkedList(), LinkedList()
inp = input('Enter Input (L1,L2) : ').split()
for i in inp[0].split('->'):
    L1.add(Node(i))
for i in inp[1].split('->'):
    L2.add(Node(i))
print("L1    :",L1)
print("L2    :",L2)
while L2.size() > 0:
    L1.add(L2.pop())
print("Merge :",L1)
