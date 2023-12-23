class Node:
    def __init__(self, value):
        self.value = value
        self.next = None
        self.previous = None

class LinkedList:
    def __init__(self):
        self.head = None
        self.tail = None

    def __str__(self):
        if self.isEmpty():
            return "Empty"
        cur, s = self.head, str(self.head.value) + " "
        while cur.next != None:
            s += str(cur.next.value) + " "
            cur = cur.next
        return s

    def reverse(self):
        if self.isEmpty():
            return "Empty"
        cur, s = self.tail, str(self.tail.value) + " "
        while cur.previous != None:
            s += str(cur.previous.value) + " "
            cur = cur.previous
        return s

    def isEmpty(self):
        return self.head == None

    def append(self, item):
        if self.head == None:
            self.head = Node(item)
            self.tail = self.head
        else:
            tmp = Node(item)
            self.tail.next = tmp
            tmp.previous = self.tail
            self.tail = tmp

    def addHead(self, item):
        if self.isEmpty():
            self.append(item)
        else:
            tmp = Node(item)
            tmp.next = self.head
            if self.head != None:
                self.head.previous = tmp
            self.head = tmp

    def insert(self, pos, item):
        cnt = 0
        if self.isEmpty():
            self.append(item)
        elif pos == 0 or (pos <= (self.size() * -1)):
            self.addHead(item)
        elif pos >= self.size():
            self.append(item)
        elif pos > 0 and pos < self.size():
            cur = self.head
            while cur != None:
                if cnt + 1 == pos:
                    tmp = Node(item)
                    tmp.previous = cur
                    tmp.next = cur.next
                    cur.next.previous = tmp
                    cur.next = tmp
                    break
                cur, cnt = cur.next, cnt + 1
        elif pos < 0:
            cur = self.tail
            while cur != None:
                if cnt - 1 == pos:
                    tmp = Node(item)
                    tmp.previous = cur.previous
                    tmp.next = cur
                    cur.previous.next = tmp
                    cur.previous = tmp
                    break
                cur, cnt = cur.previous, cnt - 1


    def search(self, item):
        cur = self.head
        while cur != None and self.size() > 0:
            if cur.value == item:
                return "Found"
            cur = cur.next
        return "Not Found"

    def index(self, item):
        cur, cnt = self.head, 0
        while cur != None and self.size() > 0:
            if cur.value == item:
                return cnt
            cur, cnt = cur.next, cnt + 1
        return -1

    def size(self):
        cur, cnt = self.head, 0
        while cur != None:
            cur, cnt = cur.next, cnt + 1
        return cnt

    def pop(self, pos):
        if self.isEmpty():
            return "Out of Range"
        if pos == 0:
            if self.size() == 1:
                self.head = None
                return "Success"
            elif self.size() > 1:
                tmp = self.head
                self.head = tmp.next
                self.head.previous = None
                tmp.next = None
                return "Success"
        cur, cnt = self.head, 0
        while cur.next != None:
            if cnt + 1 == pos:
                tmp = cur.next
                cur.next = tmp.next
                tmp.next.previous = cur
                tmp.next = None
                tmp.previous = None
                return "Success"
            cur, cnt = cur.next, cnt + 1
        return "Out of Range"

L = LinkedList()
inp = input('Enter Input : ').split(',')
for i in inp:
    if i[:2] == "AP":
        L.append(i[3:])
    elif i[:2] == "AH":
        L.addHead(i[3:])
    elif i[:2] == "SE":
        print("{0} {1} in {2}".format(L.search(i[3:]), i[3:], L))
    elif i[:2] == "SI":
        print("Linked List size = {0} : {1}".format(L.size(), L))
    elif i[:2] == "ID":
        print("Index ({0}) = {1} : {2}".format(i[3:], L.index(i[3:]), L))
    elif i[:2] == "PO":
        before = "{}".format(L)
        k = L.pop(int(i[3:]))
        print(("{0} | {1}-> {2}".format(k, before, L)) if k == "Success" else ("{0} | {1}".format(k, L)))
    elif i[:2] == "IS":
        data = i[3:].split()
        L.insert(int(data[0]), data[1])
print("Linked List :", L)
print("Linked List Reverse :", L.reverse())