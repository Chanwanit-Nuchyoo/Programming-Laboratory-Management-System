class Stack:
    def __init__(self):
        self.items = []

    def push(self, value):
        self.items.append(value)

    def pop(self):
        return self.items.pop()

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []

n = input('Enter Input : ').split(',')
S = Stack()
for i in n:
    tmp = [int(x) for x in i.split()]
    if S.isEmpty():
        S.push(tmp)
    else:
        while not S.isEmpty():
            top = S.pop()
            if top[0] < tmp[0]:
                print(top[1])
                if S.isEmpty():
                    S.push(tmp)
                    break
            elif top[0] >= tmp[0] or S.isEmpty():
                S.push(top)
                S.push(tmp)
                break