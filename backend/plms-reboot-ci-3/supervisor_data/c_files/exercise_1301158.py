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

S = Stack()
inp = input('Enter Input : ')
for i in inp:
    if i == '(' or i == '[':
        S.push(i)
    elif i == ')':
        if S.isEmpty():
            S.push(i)
        else:
            top = S.pop()
            if top != '(':
                S.push(top)
                S.push(i)
    elif i == ']':
        if S.isEmpty():
            S.push(i)
        else:
            top = S.pop()
            if top != '[':
                S.push(top)
                S.push(i)

if S.isEmpty():
    print("{0}\nPerfect ! ! !".format(S.size()))
else:
    print(S.size())