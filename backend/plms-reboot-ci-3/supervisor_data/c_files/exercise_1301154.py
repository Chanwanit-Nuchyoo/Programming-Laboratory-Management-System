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
P = Stack()
cur = Stack()
Poison = Stack()

inp = input('Enter Input : ').split(',')
for i in inp:

    if i[0] == "B":
        print(S)

    elif i[0] == "S":
        while not P.isEmpty():
            P.pop()
        while not cur.isEmpty():
            k = cur.pop()
            k = k + 2 if k % 2 == 1 else k - 1
            Poison.push(1 if k <= 0 else k)
        while not Poison.isEmpty():
            k = Poison.pop()
            cur.push(k)
            if P.isEmpty():
                P.push(k)
            else:
                while True:
                    if P.isEmpty():
                        P.push(k)
                        break
                    top = P.pop()
                    if k < top:
                        P.push(top)
                        P.push(k)
                        break
        S.items = P.items

    elif i[0] == "A":
        tmp = i.split()
        cur.push(int(tmp[1]))
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