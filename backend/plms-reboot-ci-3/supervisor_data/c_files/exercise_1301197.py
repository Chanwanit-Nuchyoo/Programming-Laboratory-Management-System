class Stack:
    def __init__(self):
        self.item = []
    def __str__(self):
        s = 'Data in Stack is : '
        for e in self.item:
            s += str(e)+ ' '
        return s
    def push(self,data):
        self.item.append(data)
    def pop(self):
        return self.item.pop()
    def peek(self):
        return self.item[-1]
    def bottom(self):
        return self.item[0]
    def size(self):
        return len(self.item)
    def isEmpty(self):
        return len(self.item) == 0

choice = int(input("Enter choice : "))
if choice == 1:
    s1 = Stack()
    s1.push(10)
    s1.push(20)
    print(s1)
    s1.pop()
    s1.push(30)
    print("Peek of stack :",s1.peek())
    print("Bottom of stack :",s1.bottom())
elif choice == 2:
    s1 = Stack()
    s1.push(100)
    s1.push(200)
    s1.push(300)
    s1.pop()
    print(s1)
    print("Stack is Empty :",s1.isEmpty())
elif choice == 3:
    s1 = Stack()
    s1.push(11)
    s1.push(22)
    s1.push(33)
    s1.pop()
    print(s1)
    print("Stack size :",s1.size())