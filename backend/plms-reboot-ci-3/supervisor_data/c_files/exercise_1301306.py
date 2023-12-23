class Stack:
    def __init__(self):
        self.items = []

    def add(self, value):
        self.items.append(value)

    def pop(self):
        return self.items.pop()

    def size(self):
        return len(self.items)

    def isEmpty(self):
        if self.items == []:
            return True
        else :
            return False

S = Stack()
n = input('Enter Input : ').split(',')
for i in n:
    if i[0] == 'A':
        S.add(i[2:])
        print("Add =",i[2:],"and Size =",S.size())
    elif i[0] == 'P':
        if S.isEmpty() :
            print("-1")
        else :
            print("Pop =",S.pop(),"and Index =",S.size())
        # print("-1" if S.isEmpty() else "Pop =",S.pop(),"and Index =",S.size())
print("Value in Stack =",' '.join(S.items) if not S.isEmpty() else "Empty")