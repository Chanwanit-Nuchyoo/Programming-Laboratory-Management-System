class Node:
    def __init__(self, value):
        self.value = value
        self.next = None

class LinkedList:
    def __init__(self, item):
        self.head = item
        self.tail = self.head

    def __str__(self):
        cur = self.head.next
        s = ""
        while cur != None:
            s += str(cur.value) + " "
            cur = cur.next
        return s

    def changeTail(self):
        cur = self.head
        while cur.next != None:
            cur = cur.next
        cur.next = Node("Tail")
        self.tail = cur.next

    def addNode(self, item):
        cur = self.head
        if cur.next == None:
            cur.next = item
        else:
            cur = self.tail.next
            prev = self.tail
            while cur != None and cur.value > item.value:
                prev = cur
                cur = cur.next
            prev.next = item
            item.next = cur

    def DelBeforeTail(self):
        if self.head.next != self.tail:
            tmp = self.head.next
            self.head.next = tmp.next
            tmp.next = None
            return tmp
        self.head.next = self.tail.next
        self.tail.next = None
        self.tail = self.head
        return "stop"

    def size(self):
        cur, cnt = self.head.next, 0
        while cur != self.tail:
            cur, cnt = cur.next, cnt + 1
        return cnt

    def final(self):
        cur = self.head.next
        s = str(cur.value)
        cur = cur.next
        while cur != self.tail:
            s += " -> " + str(cur.value)
            cur = cur.next
        return s

L, k = [], 0
for i in range(10):
    L.append(LinkedList(Node(i)))
inp = [int(i) for i in input('Enter Input : ').split()]
print('-'*60)
for i in inp:
    ind = int(abs(i) / (10 ** k)) % 10
    L[ind].addNode(Node(i))
k += 1
print("Round :",k)
for i in range(10):
    print("{0} : {1}".format(i, L[i]))
for i in range(10):
    L[i].changeTail()
print('-'*60)
while L[0].size() != len(inp):
    for i in range(10):
        while True:
            tmp = L[i].DelBeforeTail()
            if tmp == "stop":
                break
            L[int(abs(tmp.value) / (10 ** k)) % 10].addNode(tmp)
    k += 1
    print("Round :",k)
    for i in range(10):
        print("{0} : {1}".format(i, L[i]))
    for i in range(10):
        L[i].changeTail()
    print('-'*60)
print("{2} Time(s)\nBefore Radix Sort : {0}\nAfter  Radix Sort : {1}".format(' -> '.join(str(i) for i in inp), L[0].final(), k - 1))