class Node:
    def __init__(self, value):
        self.value = value
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def __str__(self):
        if self.isEmpty():
            return "Empty"
        cur, s = self.head, str(self.head.value) + " "
        while cur.next != None:
            s += str(cur.next.value) + " "
            cur = cur.next
        return s

    def isEmpty(self):
        return self.head == None

    def append(self, item):
        if self.head == None:
            self.head = Node(item)
        else:
            cur = self.head
            while cur.next != None:
                cur = cur.next
            cur.next = Node(item)

    def addHead(self, item):
        tmp = Node(item)
        tmp.next = self.head
        self.head = tmp

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
                tmp.next = None
                return "Success"
        cur, cnt = self.head, 0
        while cur.next != None:
            if cnt + 1 == pos:
                tmp = cur.next
                cur.next = tmp.next
                tmp.next = None
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
print("Linked List :", L)