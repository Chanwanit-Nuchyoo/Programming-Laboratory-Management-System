class Queue:
    def __init__(self, items = []):
        self.items = items

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

    def checkDup(self):
        if self.size() == len(set(self.items)):
            return "NO Duplicate"
        return "Duplicate"

inp1, inp2 = input('Enter Input : ').split('/')
Q = Queue([int(i) for i in inp1.split()])
for i in inp2.split(','):
    if i[0] == 'D':
        Q.deQ()
    elif i[0] == 'E':
        Q.enQ(int(i[2:]))
print(Q.checkDup())