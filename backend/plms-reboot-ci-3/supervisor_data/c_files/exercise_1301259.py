class item:
    def __init__(self, key, data):
        self.key = key
        self.data = data

    def __str__(self):
        return "({0}, {1})".format(self.key, self.data)

class hash:
    def __init__(self, size, maxCollision):
        self.size = size
        self.max = maxCollision
        self.table = [None] * size
        self.ch = False

    def put(self, item):
        if None not in self.table:
            if not self.ch:
                print('This table is full !!!!!!')
                self.ch = True
            return
        n_collision = 0
        while n_collision != self.max:
            ind = self.hash(item, n_collision)
            if self.table[ind] == None:
                self.table[ind] = item
                break
            elif n_collision < self.max:
                n_collision += 1
                print('collision number',n_collision,'at',ind)
        else:
            print('Max of collisionChain')
        for i in range(len(self.table)):
            print('#',i+1,'\t',self.table[i],sep ='')
        print('---------------------------')


    def hash(self, item, n_col):
        cnt = 0
        for i in item.key:
            cnt += ord(i)
        return  (cnt + (n_col ** 2)) % self.size 

print(' ***** Fun with hashing *****')
inp, q = input('Enter Input : ').split('/')
h = hash(int(inp.split()[0]), int(inp.split()[1]))
for i in q.split(','):
    h.put(item(i.split()[0], i.split()[1]))