class Node:
    def __init__(self, data):
        self.data = data
        self.left = None
        self.right = None
    
    def __str__(self):
        return str(self.data)

class BST:
    def __init__(self):
        self.root = None

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

    def findmax(self, node):
        if node == None:
            return float('-inf')
        res = node.data
        rres = self.findmax(node.right)
        if rres > res:
            res = rres
        return res

T = BST()
inp = [int(i) for i in input('Enter Input : ').split()]
for i in inp:
    root = T.insert(i)
T.printTree(root)
print('-' * 50)
print("Min : {0}".format(T.findmin(root)))
print("Max : {0}".format(T.findmax(root)))