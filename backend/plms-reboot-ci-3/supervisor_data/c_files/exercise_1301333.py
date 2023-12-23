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

    def printTree(self, node, level=0):
        if node != None:
            self.printTree(node.right, level + 1)
            print('     ' * level, node)
            self.printTree(node.left, level + 1)

    def checkpos(self, val):
        if val == self.root.data:
            print("Root")
        else:
            cur = self.root
            while True:
                if val < cur.data and cur.left != None:
                    cur = cur.left
                elif val > cur.data and cur.right != None:
                    cur = cur.right
                elif val < cur.data and cur.left == None:
                    print("Not exist")
                    break
                elif val > cur.data and cur.right == None:
                    print("Not exist")
                    break
                elif val == cur.data:
                    if cur.left != None or cur.right != None:
                        print("Inner")
                        break
                    else:
                        print("Leaf")
                        break


T = BST()
inp = [int(i) for i in input('Enter Input : ').split()]
for i in range(1, len(inp)):
    root = T.insert(inp[i])
T.printTree(root)
T.checkpos(inp[0])
