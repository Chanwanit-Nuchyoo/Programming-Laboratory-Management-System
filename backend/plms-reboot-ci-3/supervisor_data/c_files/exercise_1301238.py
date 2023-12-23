class Node:
    def __init__(self, data):
        self.data = data
        self.left = None
        self.right = None
    
    def __str__(self):
        return str(self.data)

class AVL:
    def printTree(self, node, level = 0):
        if node != None:
            self.printTree(node.right, level + 1)
            print('     ' * level, node)
            self.printTree(node.left, level + 1)

    def insert(self, r, data):
        if not r:
            return Node(data)
        elif data < r.data:
            r.left = self.insert(r.left, data)
        else:
            r.right = self.insert(r.right, data)
        hl = self.height(r.left)
        hr = self.height(r.right)
        if (hl - hr) >= 2:
            if self.height(r.left.left) > self.height(r.left.right):
                r = self.LL(r)
            else:
                r = self.RL(r)
        elif (hl - hr) <= -2:
            if self.height(r.right.left) > self.height(r.right.right):
                r = self.LR(r)
            else:
                r = self.RR(r)
        return r

    def height(self, r):
        if r != None:
            hl = self.height(r.left)
            hr = self.height(r.right)
            if hl > hr:
                return hl + 1
            return hr + 1
        return -1
    
    def LL(self, x):
        y = x.left
        x.left = y.right
        y.right = x
        return y

    def RR(self, x):
        y = x.right
        x.right = y.left
        y.left = x
        return y

    def RL(self, x):
        y = x.left
        x.left = self.RR(y)
        return self.LL(x)

    def LR(self, x):
        y = x.right
        x.right = self.LL(y)
        return self.RR(x)

T, root = AVL(), None
inp = [int(i) for i in input('Enter Input : ').split()]
for i in inp:
    print("Insert : ( {0} )".format(i))
    root = T.insert(root, i)
    T.printTree(root)
    print('-' * 50)