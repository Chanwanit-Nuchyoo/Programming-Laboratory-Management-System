class Queue:
    def __init__(self):
        self.items = []

    def __str__(self):
        return str(self.deQ()[1])

    def enQ(self, value):
        self.items.append(value)

    def deQ(self):
        return self.items.pop(0)

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []

    def sortPosition(self):
        cur_sec = self.items[-1][0]
        for i in range(self.size() - 2, -1, -1):
            if self.items[i][0] == cur_sec:
                tmp = self.size() - 1
                while (tmp - 1) > i:
                    self.items[tmp], self.items[tmp - 1] = self.items[tmp - 1], self.items[tmp]
                    tmp -= 1
                break

Q = Queue()
inp1, inp2 = input('Enter Input : ').split('/')
inp = []
for i in inp1.split(','):
    a, b = i.split()
    inp.append([int(a), int(b)])
for i in inp2.split(','):
    if i[0] == "D":
        print("Empty" if Q.isEmpty() else Q)
    elif i[0] == "E":
        k = int(i[2:])
        for j in inp:
            if j[1] == k:
                Q.enQ(j)
                Q.sortPosition()
                break