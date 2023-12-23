class Node:
    def __init__(self, data): 
        self.data = data  
        self.left = None  
        self.right = None 
        self.level = None 

    def __str__(self):
        return str(self.data) 

class BinarySearchTree:
    def __init__(self): 
        self.root = None

    def insert(self, val):  
        if self.root == None:
            self.root = Node(val)
        else:
            current = self.root
         
            while True:
                if val < current.data:
                    if current.left:
                        current = current.left
                    else:
                        current.left = Node(val)
                        break
                elif val > current.data:
                    if current.right:
                        current = current.right
                    else:
                        current.right = Node(val)
                        break
                else:
                    break
    def delete(self,r, data):
        if r != None:
            if r.data == data:
                if r.left == None and r.right == None:
                    return None
                elif r.left != None and r.right == None:
                    return r.left
                elif r.right != None and r.left == None:
                    return r.right
                else:
                    def find_successer(root):
                        if root.left != None:
                            return find_successer(root.left)
                        else:
                            return root
                    x = find_successer(r.right)
                    r = self.delete(r,x.data)
                    x.right = r.right
                    x.left = r.left
                    return x
            elif data < r.data:
                r.left = self.delete(r.left,data)
            else:
                r.right = self.delete(r.right,data)
            return r
        else:
            print("Error! Not Found DATA")
            return None
                
def printTree90(node, level = 0):
    if node != None:
        printTree90(node.right, level + 1)
        print('     ' * level, node)
        printTree90(node.left, level + 1)


tree = BinarySearchTree()
data = input("Enter Input : ").split(",")
for e in data:
    a,b = e.split()
    if a == "i":
        print("insert",b)
        tree.insert(int(b))
    elif a == "d":
        print("delete",b)
        tree.root = tree.delete(tree.root,int(b))
    printTree90(tree.root)