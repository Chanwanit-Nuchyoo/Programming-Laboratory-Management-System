class Node:
    def __init__(self, data):
        self.data = data
        self.next = None

class LinkedList:
    def __init__(self):
        self.head = None

    def __str__(self):
        if self.isEmpty():
            return "List is empty"
        cur, s = self.head,"link list : "
        while cur != None:
            s += str(cur.data)
            if cur.next!= None:
                s += "->"
            cur = cur.next
        return s

    def __iter__(self):
        node = self.head
        while node is not None:
            yield node
            node = node.next

    def isEmpty(self):
        return self.head == None

    def append(self, data):
        if self.isEmpty():
            self.head = Node(data)
        else:
            for current_node in self:
                pass
            current_node.next = Node(data)
    
    def insert(self, index, data):
        if self.isEmpty():
            if index == 0:
                self.head = Node(data)
                return "index = {0} and data = {1}".format(index,data)
            return "Data cannot be added"
        if index < 0:
            return "Data cannot be added"
        i = 0
        new_node = Node(data)
        for node in self:
            if index == 0:
                new_node.next = node
                self.head = new_node
                return "index = {0} and data = {1}".format(index,data)
            elif i+1 == index:
                new_node.next = node.next
                node.next = new_node
                return "index = {0} and data = {1}".format(index,data)
            i += 1
        else:
            return "Data cannot be added"

ll = LinkedList()
data = input("Enter Input : ").split(",")
for e in data[0].split(" "):
    if e !='':
        ll.append(int(e))
print(ll)
for e in data[1:]:
    i,d = e.split(":")
    print(ll.insert(int(i),d))
    print(ll)