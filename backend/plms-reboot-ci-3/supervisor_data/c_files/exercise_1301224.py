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

    def LessThan(self, node, val):
        if node != None:
            return self.LessThan(node.left, val) + (1 if node.data <= val else 0) + self.LessThan(node.right, val)
        return 0

T = BST()
inp1 = input('Enter Input : ').split('/')
inp = list(map(int, inp1[0].split()))
for i in inp:
    root = T.insert(i)
T.printTree(root)
print('-' * 50)
print(T.LessThan(root, int(inp1[1])))