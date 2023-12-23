class Node: 

    # Constructor to initialize the node object 
    def __init__(self, data): 
        self.data = data 
        self.next = None

    def __str__(self):
        return str(self.data)
  
class LinkedList: 
  
    # Function to initialize head 
    def __init__(self): 
        self.head = None

    def __iter__(self):
        node = self.head
        while node is not None:
            yield node
            node = node.next

    def __str__(self):
        if self.isEmpty():
            return "Empty"
        return "->".join(str(node) for node in self)
    
    def isEmpty(self):
        return self.head == None
  
    # Function to insert a new node at the beginning 
    def append(self, new_data):
        if self.isEmpty():
            self.head = Node(new_data)
        else: 
            for node in self:
                pass 
            node.next = Node(new_data)  
  
    def detectLoop(self): 
        slow_p = self.head 
        fast_p = self.head 
        while(slow_p and fast_p and fast_p.next): 
            slow_p = slow_p.next
            fast_p = fast_p.next.next
            if slow_p == fast_p: 
                return True
        return False
  
# Driver program for testing 
llist = LinkedList() 
data_l = input("Enter input : ")
for e in data_l.split(","):
    mode,data = e.split(" ")
    if mode == 'A':
        llist.append(data)
        print(llist)
    elif mode == 'S':
        node_current_index, node_next_index = data.split(":")
        node_current, node_next = None,None
        i = 0
        if(not llist.isEmpty()):
            for node in llist:
                if i == int(node_current_index):
                    node_current = node
                if i == int(node_next_index):
                    node_next = node
                i += 1
            
            if node_current == None:
                print("Error! {index not in length}:",node_current_index)
            else:
                if node_next == None:
                    print("index not in length, append :",node_next_index)
                    llist.append(node_next_index)
                else:
                    node_current.next = node_next
                    print("Set node.next complete!, index:value = {0}:{1}".format(node_current_index,node_current),\
                        "-> {0}:{1}".format(node_next_index,node_next))
        else:
            print("Error! {list is empty}")

if(llist.detectLoop()): 
        print("Found Loop")
else: 
        print("No Loop")
        print(llist)