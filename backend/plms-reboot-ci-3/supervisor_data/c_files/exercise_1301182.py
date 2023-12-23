class Node:
    def __init__(self, data):
        self.data = data
        self.next = None
        self.previous = None

    def __str__(self):
        return str(self.data)

class LinkedList:
    def __init__(self):
        self.dummyhead,self.dummytail = Node(None),Node(None)
        self.head,self.tail = self.dummyhead,self.dummytail
        self.head.next = self.tail
        self.tail.previous = self.head
        self.size = 0

    def __iter__(self):
        node = self.head
        while node is not None:
            yield node
            node = node.next

    def __iter__reverse(self):
        node = self.tail
        while node is not None:
            yield node
            node = node.previous
    
    def __str__(self):
        return "linked list : "+'->'.join(str(node) for node in self if node != self.dummyhead and node != self.dummytail)+"\n"+self.str_reverse()

    def str_reverse(self):
        return "reverse : "+'->'.join(str(node) for node in self.__iter__reverse() if node != self.dummyhead and node != self.dummytail)

    def isEmpty(self):
        return self.size == 0
    
    def append(self, data):
        new_node = Node(data)
        self.tail.previous.next = new_node
        new_node.previous = self.tail.previous

        new_node.next = self.tail
        self.tail.previous = new_node
        self.size += 1

    def add_before(self, data):
        new_node = Node(data)
        self.head.next.previous = new_node
        new_node.next = self.head.next

        new_node.previous = self.head
        self.head.next = new_node
        self.size += 1

    def insert(self, index, data):
        if index < 0:
            return "Data cannot be added\n" + self.__str__()
        i = 0
        new_node = Node(data)
        for node in self:
            if i == index and i <= self.size:
                node.next.previous = new_node
                new_node.next = node.next

                new_node.previous = node
                node.next = new_node
                self.size += 1
                return "index = {0} and data = {1}\n".format(index,data)+self.__str__()
            i += 1
        else:
            return "Data cannot be added\n" + self.__str__()
        
    def remove(self, data):
        i = -1
        for node in self:
            if node.data == data:
                node.previous.next = node.next
                node.next.previous = node.previous
                
                node.next = None
                node.previous = None
                self.size -= 1
                return "removed : "+ str(node) +" from index : "+str(i)+ "\n" + self.__str__()
            i += 1 
        else:
            return "Not Found!\n" + self.__str__()


ll = LinkedList()
datas = input("Enter Input : ").split(",")
for e in datas:
    command,data = e.split()
    if command == 'A':
        ll.append(data)
        print(ll)
    elif command == 'Ab':
        ll.add_before(data)
        print(ll)
    elif command == 'I':
        index,value = data.split(":")
        print(ll.insert(int(index),value))
    elif command == 'R':
        print(ll.remove(data))
