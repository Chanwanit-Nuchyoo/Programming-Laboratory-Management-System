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

inp = input('Enter Input : ').split()
S = Stack()
cnt = 0
for i in inp:
    if S.isEmpty():
        S.push(i)
    else:
        top = S.pop()
        if i != top or S.isEmpty():
            S.push(top)
            S.push(i)
        else:
            second_top, cnt = S.pop(), cnt + 1
            if i != second_top:
                S.push(second_top)
                S.push(top)
                S.push(i)
                cnt -= 1
    
print(S.size())
if S.size() == 0:
    print("Empty")
else:
    while not S.isEmpty():
        print(S.pop(),end='')
    print()
if cnt >= 2:
    print("Combo : {} ! ! !".format(cnt))