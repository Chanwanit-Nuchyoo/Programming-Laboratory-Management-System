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

    def vipPSD(self, value):
        for i in range(self.size()):
            if self.items[i][0] == "NOT":
                self.items.insert(i, value)
                break
        else:
            self.enQ(value)

Q = Queue()
n = input('Enter Input : ').split(',')
for i in n:
    if i[0] == "D":
        if Q.isEmpty():
            print("Empty")
        else:
            print(Q.deQ()[1])
    elif i[0:2] == "ES":
        Q.vipPSD(["SURVEY", i[3:]])
    elif i[0:2] == "EN":
        Q.enQ(["NOT", i[3:]])