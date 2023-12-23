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

inp = input('Enter Infix : ')
S = Stack()
print('Postfix : ', end='')
for i in inp:
    if i.isalpha():
        print(i, end='')
    else:
        if i in '(^':
            S.push(i)
        elif i in ')':
            while True:
                top = S.pop()
                if top not in '(':
                    print(top, end='')
                else:
                    break
        elif i in '*/':
            if S.isEmpty():
                S.push(i)
            else:
                while True:
                    if S.isEmpty():
                        S.push(i)
                        break
                    top = S.pop()
                    if top in '^*/':
                        print(top, end='')
                    else:
                        S.push(top)
                        S.push(i)
                        break
        elif i in '+-':
            if S.isEmpty():
                S.push(i)
            else:
                while True:
                    if S.isEmpty():
                        S.push(i)
                        break
                    top = S.pop()
                    if top in '^*/+-':
                        print(top, end='')
                    else:
                        S.push(top)
                        S.push(i)
                        break
while not S.isEmpty():
    print(S.pop(), end='')
print()