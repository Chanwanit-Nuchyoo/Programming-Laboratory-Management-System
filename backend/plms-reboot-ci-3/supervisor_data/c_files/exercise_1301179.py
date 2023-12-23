class Node:
    def __init__(self, value):
        self.value = value
        self.next = None
        self.previous = None

class LinkedList:
    def __init__(self):
        self.head = Node("HEAD")
        self.tail = Node("TAIL")
        self.head.next = self.tail
        self.tail.previous = self.head
        self.cursor = self.head

    def __str__(self):
        cur = self.head.next
        if cur == self.tail:
            return "|"
        if self.cursor == self.head:
            s = "| "
            while cur != self.tail:
                s += str(cur.value) + " "
                cur = cur.next
            return s
        else:
            s = str(cur.value) + " "
            ch = 0
            while cur.next != self.tail:
                if cur == self.cursor:
                    s += "| "
                    ch = 1
                cur = cur.next
                s += str(cur.value) + " "
            return s + "| " if ch == 0 else s

    def Insert(self, value):
        tmp = Node(value)
        if self.cursor == self.tail:
            tmp.next = self.tail
            tmp.previous = self.tail.previous
            self.tail.previous.next = tmp
            self.tail.previous = tmp
            self.cursor = tmp
        else:
            tmp.previous = self.cursor
            tmp.next = self.cursor.next
            self.cursor.next.previous = tmp
            self.cursor.next = tmp
            self.cursor = tmp

    def Left(self):
        if self.cursor == self.tail and self.head.next == self.tail:
            self.cursor = self.head
        elif self.cursor != self.head:
            self.cursor = self.cursor.previous

    def Right(self):
        if self.cursor == self.head and self.tail.previous == self.head:
            self.cursor = self.tail
        elif self.cursor.next != self.tail:
            self.cursor = self.cursor.next

    def Backspace(self):
        if self.cursor != self.head:
            tmp = self.cursor
            self.cursor = self.cursor.previous
            tmp.previous.next = tmp.next
            tmp.next.previous = tmp.previous
            tmp.next, tmp.previous = None, None

    def Delete(self):
        if self.cursor.next != self.tail:
            tmp = self.cursor.next
            self.cursor.next = tmp.next
            tmp.next.previous = tmp.previous
            tmp.next, tmp.previous = None, None

L = LinkedList()
inp = input('Enter Input : ').split(',')
for x in inp:
    if x[0] == "I":   L.Insert(x[2:])
    elif x[0] == "L": L.Left()
    elif x[0] == "R": L.Right()
    elif x[0] == "B": L.Backspace()
    elif x[0] == "D": L.Delete()
print(L)