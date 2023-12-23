class Node:
    def __init__(self,x=None):
        self.data = x
        self.right = None
        self.left = None

    def __str__(self):
        return str(self.data)

class BST:
    def __init__(self,root=None):
        self.root = root

    def printTree(self, node, level = 0):
        if node != None:
            self.printTree(node.right, level + 1)
            print('     ' * level, node)
            self.printTree(node.left, level + 1)

    def insert(self, data):
        if self.root == None:
            self.root = Node(data)
        else:
            cur = self.root
            while True:
                if data < cur.data and cur.left != None:
                    cur = cur.left
                elif data >= cur.data and cur.right != None:
                    cur = cur.right
                elif data < cur.data:
                    cur.left = Node(data)
                    break
                else:
                    cur.right = Node(data)
                    break
        return self.root

    def findmin(self, node):
        if node == None:
            return float('inf')
        res = node.data
        lres = self.findmin(node.left)
        if lres < res:
            res = lres
        return res
    
    def below(self,root,value):
        min = self.findmin(root)
        if min >= value :
            print('Not have')
        else :
            self.findbelow(root,value)

    def findbelow(self,root,value):
        if root == None:
            return float('-inf')
        else:
            res = root.data
            if res < value :
                self.findbelow(root.left,value)
                print(str(res),end=' ')
                self.findbelow(root.right,value)
            elif res >= value : 
                self.findbelow(root.left,value)

T = BST()
in1,in2 = input('Enter Input : ').split('|')
value = int(in2)
tree = in1.split(' ')
for i in range(len(tree)):
    tree[i] = int(tree[i])
for i in tree:
    root = T.insert(i)
T.printTree(root)
print('-' * 50)
print('Below '+in2+' : ',end='')
T.below(root,value)
        
