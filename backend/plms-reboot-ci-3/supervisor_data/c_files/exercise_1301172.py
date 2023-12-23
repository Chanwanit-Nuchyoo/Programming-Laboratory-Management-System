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
        
    def __str__(self):
        return str(', '.join(self.items))

Q = Queue()
Q2 = Queue()
n = input('Enter Input : ').split(',')
for i in n:
    if i[0] == 'E':
        Q.enQ(i[2:])
        print(Q)
    elif i[0] == 'D':
        if Q.isEmpty():
            print("Empty")
        else:
            x = Q.deQ()
            Q2.enQ(x)
            print(x + " <-",Q if not Q.isEmpty() else "Empty")
print(Q2 if not Q2.isEmpty() else "Empty",end=" : ")
print(Q if not Q.isEmpty() else "Empty")
