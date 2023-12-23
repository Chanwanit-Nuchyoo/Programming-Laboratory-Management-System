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
            print("*", end='')
            self.root = Node(data)
        else:
            cur = self.root
            while True:
                if data < cur.data and cur.left != None:
                    print("L", end='')
                    cur = cur.left
                elif data >= cur.data and cur.right != None:
                    print("R", end='')
                    cur = cur.right
                elif data < cur.data:
                    print("L*", end='')
                    cur.left = Node(data)
                    break
                else:
                    print("R*", end='')
                    cur.right = Node(data)
                    break
        return self.root

T = BST()
inp1 = input('Enter Input : ').split('/')
inp = list(map(int, inp1[0].split()))
for i in inp:
    root = T.insert(i)
    print()