class Stack:
    def __init__(self):
        self.items = []

    def __str__(self):
        return str(self.size())

    def push(self, value):
        self.items.append(value)

    def pop(self):
        return self.items.pop()

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []

S = Stack()
inp = input('Enter Input : ').split(',')
for i in inp:
    #print("i =",i)
    if i[0] == "B":
        print(S)
    elif i[0] == "A":
        tmp = i.split()
        if S.isEmpty():
            S.push(int(tmp[1]))
        else:
            while True:
                if S.isEmpty():
                    S.push(int(tmp[1]))
                    break
                top = S.pop()
                if int(tmp[1]) < top:
                    S.push(top)
                    S.push(int(tmp[1]))
                    break