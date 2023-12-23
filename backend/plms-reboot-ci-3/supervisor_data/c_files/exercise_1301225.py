class Stack:
    def __init__(self):
        self.items = []

    def push(self, data):
        self.items.append(data)

    def pop(self):
        return self.items.pop()

class Node:
    def __init__(self, val):
        self.data = val
        self.left, self.right = None, None

    def __str__(self):
        return str(self.data)

def printTree(r, level = 0):
    if r != None:
        printTree(r.right, level + 1)
        print('     ' * level, r)
        printTree(r.left, level + 1)

def printInfix(r):
    if r.left != None:
        print("(", end="")
        printInfix(r.left)
    print(r, end="")
    if r.right != None:
        printInfix(r.right)
        print(")", end="")

def printPrefix(r):
    if r != None:
        print(r, end="")
        printPrefix(r.left)
        printPrefix(r.right)

S = Stack()
inp = input('Enter Postfix : ')
for i in inp:
    if i in '+-*/':
        b, a = S.pop(), S.pop()
        tmp = Node(i)
        tmp.left, tmp.right = a, b
        S.push(tmp)
    else:
        S.push(Node(i))
root = S.pop()
print("Tree :")
printTree(root)
print('-' * 50)
print("Infix : ", end="")
printInfix(root)
print()
print("Prefix : ", end="")
printPrefix(root)
print()