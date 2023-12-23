class node:
    def __init__(self,data,left=None,right=None):
        self.data = data
        self.left = left
        self.right = right
    def __str__(self):
        return str(self.data)

def insert(r,val):
    if r != None :
        if val < r.data :
            r.left = insert(r.left,val) 
        else:
            r.right = insert(r.right,val)
        return r
    else:
        return node(val)
        

def print90(r,level=0):
    if r != None :
        print90(r.right,level+1)
        print('     ' * level,r)
        print90(r.left,level+1)

inp1,rank = input('Enter Input : ').split('/')
rank = int(rank)
inp = list(map(int, inp1.split()))
root = node(inp.pop(0))
for i in inp:
    root = insert(root,i)
print90(root)
print('-'*50)

def findrank(r,v):
    #print('visit',r)
    if r != None :
        l = findrank(r.left,v)
        return l + ( (1 + findrank(r.right,v)) if r.data<=v else 0)
    else:
        return 0

print('Rank of',rank,':',findrank(root,rank))