class hash:
    def __init__(self, size, maxCollision, threshold, primes):
        self.size = size
        self.maxCollision = maxCollision
        self.threshold = threshold
        self.table = [None] * size
        self.queue_input = []
        self.primes = primes

    def first_greater(self, l, r, x):
        ans = 999
        while l <= r:
            m = int((l + r) / 2)
            if self.primes[m] <= x:
                l = m + 1
            else:
                ans = min(self.primes[m], ans)
                r = m - 1
        return ans

    def rehash(self):
        prime_size = self.first_greater(0, len(self.primes) - 1, self.size * 2)
        self.table = [None] * prime_size
        self.size = prime_size
        for i in self.queue_input:
            self.put(i, False)
        
    def printTable(self):
        for i in range(len(self.table)):
            print('#',i+1,'\t',self.table[i],sep ='')
        print('----------------------------------------')

    def put(self, data, ch_re=True):
        if ch_re:
            self.queue_input.append(data)
        if len(self.queue_input) > int(self.threshold / 100 * self.size):
            if ch_re:
                print("****** Data over threshold - Rehash !!! ******")
            self.rehash()
            return True
        n_col = 0
        while n_col != self.maxCollision:
            ind = (data + (n_col ** 2)) % self.size
            if self.table[ind] == None:
                self.table[ind] = data
                return
            elif n_col < self.maxCollision:
                n_col += 1
                print('collision number',n_col,'at',ind)
        print("****** Max collision - Rehash !!! ******")
        self.rehash()
        return

def seieve():
    primes = []
    for i in range(2, 501):
        primes.append(i)
    i = 2
    while i <= (501 ** (1 / 2)):
        if i in primes:
            for j in range(i * 2, 501, i):
                if j in primes:
                    primes.remove(j)
        i += 1
    return primes

print(' ***** Rehashing *****')
inp, q = input('Enter Input : ').split('/')
h = hash(int(inp.split()[0]), int(inp.split()[1]), int(inp.split()[2]), seieve())
print('Initial Table :')
h.printTable()
for i in list(map(int, q.split())):
    print("Add :", i)
    h.put(i)
    h.printTable()