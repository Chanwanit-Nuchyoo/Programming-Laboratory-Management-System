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

def encodemsg(Q1,Q2):
    temp1 = []
    if not Q1.isEmpty() and not Q2.isEmpty():
        for i in range(Q1.size()):
            a = Q1.dequeue()
            b = Q2.dequeue()
            if a.isupper():
                a = ord(a) + b
                if a > 90:
                    a -= 26
                temp1.append(chr(a))
            else :
                a = ord(a) + b 
                if a > 122:
                    a -= 26
                temp1.append(chr(a))
            Q2.enqueue(b)
        Q1.value = temp1
        x = Q1.size()%Q2.size()
        for i in range(Q2.size()-x):
            Q2.enqueue(Q2.dequeue())
    print("Encode message is : ",Q1)

def decodemsg(Q1,Q2):
    temp1 = []
    temp2 = []
    if not Q1.isEmpty() and not Q2.isEmpty():
        for i in range(Q1.size()):
            a = Q1.dequeue()
            if Q2.isEmpty():
                Q2.value = temp2
            b = Q2.dequeue()
            if a.isupper():
                a = ord(a) - b
                if a < 65:
                    a += 26
                temp1.append(chr(a))
                temp2.append(b)
            else :
                a = ord(a) - b 
                if a < 97:
                    a += 26
                temp1.append(chr(a))
                temp2.append(b)
        Q1.value = temp1
    print("Decode message is : ",Q1)

ip,code= input("Enter String and Code : ").split(',')
l1 = []
l2 = []
for i in ip:
    if i != ' ':
        l1.append(i)
for i in code:
    if i != ' ':
        l2.append(int(i))
q1 = Queue(l1)
q2 = Queue(l2)
encodemsg(q1, q2)
decodemsg(q1, q2)