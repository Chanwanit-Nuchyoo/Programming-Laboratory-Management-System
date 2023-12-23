class Queue:
    def __init__(self):
        self.items = []

    def enQ(self, value):
        self.items.append(value)

    def deQ(self):
        return self.items.pop(0)

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []

Q = Queue()
n = input('Enter Input : ').split(',')
for i in n:
    if i[0] == 'E':
        Q.enQ(i[2:])
        print(Q.size())
    elif i[0] == 'D':
        print("-1" if Q.isEmpty() else Q.deQ() + " 0")
print(' '.join(Q.items) if not Q.isEmpty() else "Empty")