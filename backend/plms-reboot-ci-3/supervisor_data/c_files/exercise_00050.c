class NodeQ:
def __init__(self, item=None):
		self.data=item
		self.next=None
		
class Queue:
	def __init__(self, item=None):
		if(item==None):
			self.first= None
		else:
			self.first=NodeQ(item)
		
	def __str__(self):
		content = ""
		if self.isEmpty():
			content = "Nothing in the queue"
		else:
			current_node = self.first
			while current_node != None:
				content += current_node.data+" "
				current_node = current_node.next
		return content
		
	def __len__(self):
		count=0
		current_node = self.first
		while current_node.next != None:
			count += 1
			current_node = current_node.next
		return count
			
	def isEmpty(self):
		return self.first == None

	
	def enqueue(self,item):
		if self.isEmpty():
			self.first = NodeQ(item)
			return
		
		current_node = self.first
		while current_node.next != None:
			current_node = current_node.next
		current_node.next = NodeQ(item)
	
	
	
	def dequeue(self):
		if self.first == None:
			return False
			
		current_node = self.first
		self.first = self.first.next
		
		return current_node.data
		
		
class Node:
	def __init__(self,item):
		self.data = item
		self.leftchild = None
		self.rightchild = None
		self.parent = None
				
class BinaryTree():
	 def __init__(self,root):
        self.root = Node(root)
        
	def __str__(self):
		content = "Level Order Traversal"

   
    def insert(self, data):
        if self.root:
            return self.root.insert(data)
        else:
            self.root = Node(data)
            return True
        
    def find(self,data):
        if self.root:
            return self.root.find(data)
        else:
            return False
        
    def preorder(self):
        if self:
            print(str(self.value))
            if self.leftChild:
                self.leftChild.preorder()
            if self.rightChild:
                self.rightChild.preorder()
                
    def postorder(self):
        if self:        
            if self.leftChild:
                self.leftChild.postorder()
            if self.rightChild:
                self.rightChild.postorder() 
            print(str(self.value))
            
    def inorder(self):
        if self:        
            if self.leftChild:
                self.leftChild.inorder()
            print(str(self.value))
            if self.rightChild:
                self.rightChild.inorder() 		
class Heap(BinaryTree):
	def __init__(self):
		super().__init__()
		self.root = None
		self.size = 0
		
	
		
		return content
	def append(self,item):
		if self.size == 0:
			self.root = NodeH(item)
			
		elif self.leftchild == None:
			self.leftchild = NodeH(item)
			self.leftchild.parent = self.root
			
		elif self.rightchild == None:
			self.rightchild = NodeH(item)
			self.rightchild.parent = self.root
			
		self.size += 1
		
	def heapify(self,node):
		pass
	def remvoe(self):
		pass
	
# main program start below
print(" *** Heap sort (Min) ***")
str = input("Enter data : ")
h = Heap()
q = Queue()
for n in str.split():
	print("Inserting ",n)
	q.enqueue(n)
	print(q)	
while not q.isEmpty():
	q.dequeue()
	print(q)
for n in str.split():
	print("Level order")
print(h)
