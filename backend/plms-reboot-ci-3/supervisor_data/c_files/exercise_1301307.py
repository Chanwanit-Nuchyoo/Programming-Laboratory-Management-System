class Stack():
    
    def __init__(self, ls = None):
        if ls == None:
            self.items = []
        else:
            self.items = ls
    
    def push(self,i):
        self.items.append(i)
    
    def pop(self):
        return self.items.pop()
    
    def isEmpty(self):
        return len(self.items) == 0
    
    def size(self):
        return len(self.items)


def postFixeval(st):
    s = Stack()
    for i in st:
        if i not in "+-*/":
            s.push(i)
        elif not s.isEmpty():
                n1 = str(s.pop())
                n2 = str(s.pop())
                t = n2 + i + n1
                temp = eval(t)
                s.push(temp)
    return s.pop()
            

print(" ***Postfix expression calcuation***")
token = list(input("Enter Postfix expression : ").split())

print("Answer : ",'{:.2f}'.format(postFixeval(token)))