class Node:
    def __init__(self, data):
        self.data = data
        self.left, self.right = None, None

    def __str__(self):
        return str(self.data)

class BST:
    def __init__(self):
        self.root = None

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

    def preorder(self, node):
        if node != None:
            print(node, end=" ")
            self.preorder(node.left)
            self.preorder(node.right)

    def inorder(self, node):
        if node != None:
            self.inorder(node.left)
            print(node, end=" ")
            self.inorder(node.right)

    def postorder(self, node):
        if node != None:
            self.postorder(node.left)
            self.postorder(node.right)
            print(node, end=" ")

    def BFS(self, node):
        queue = [self.root]
        while queue != []:
            front = queue.pop(0)
            if front.left != None:
                queue.append(front.left)
            if front.right != None:
                queue.append(front.right)
            print(front, end=" ")

T = BST()
inp = [int(i) for i in input('Enter Input : ').split()]
for i in inp:
    root = T.insert(i)
print("Preorder : ", end="")
T.preorder(root)
print()
print("Inorder : ", end="")
T.inorder(root)
print()
print("Postorder : ", end="")
T.postorder(root)
print()
print("Breadth : ", end="")
T.BFS(root)
print()