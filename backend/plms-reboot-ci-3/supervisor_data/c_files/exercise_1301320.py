class Queue :
    def __init__(self,value=None):
        if value != None:
            self.value = value
        else :
            self.value = []
    def isEmpty(self):
        if self.value == [] :
            return True
        else:
            return False
    def __str__(self):
        return str(self.value)
    def enqueue(self,x):
        return self.value.append(x)   
    def dequeue(self):
        return self.value.pop(0)
    def size(self):
        return len(self.value)

mes , code = input("Enter code,hint : ").split(",")
meslis = []
meslis[:0] = mes
q1 = Queue(meslis)
answer =Queue()
if ord(meslis[0]) > ord(code):
    dif = ord(meslis[0]) - ord(code)
    while q1.size() > 0:
        answer.enqueue(chr(ord(q1.dequeue())-dif))
        print(answer)
else:
    dif = ord(code) - ord(meslis[0])
    while q1.size() > 0:
        answer.enqueue(chr(ord(q1.dequeue())+dif))
        print(answer)

