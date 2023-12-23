class Stack :
    def __init__(self,list = None) :
        if list == None :
            self.item = []
        else :
            self.item = list()

    def isEmpty(self) :
        return self.item == []
    
    def push(self,data) :
        return self.item.append(data)
        
    def pop(self) :
        if not self.isEmpty() :
            return self.item.pop()
        
    def size(self) :
        return len(self.item)

    def peek(self) :
        return self.item[-1]


def dec2bin(decnum):
    s = Stack()
    str_ans = ''
    while decnum > 0:
        dig = decnum % 2
        decnum = decnum // 2
        s.push(dig)
    while not s.isEmpty():
        str_ans += str(s.pop())
    return str_ans

print(" ***Decimal to Binary use Stack***")
token = input("Enter decimal number : ")
print("Binary number : ",end='')
print(dec2bin(int(token)))