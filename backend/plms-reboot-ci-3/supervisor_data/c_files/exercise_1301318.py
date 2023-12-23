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

q1 = Queue() #closeest but slowest
q2 = Queue()
ip = input("Enter people and time : ").split(' ')
man = []
man[:0] , time = ip[0] , int(ip[1])
Q = Queue(man)
count1 , count2 = 3 , 2
for i in range(0,time):
    if count1 == 0 and q1.size()>0:
        q1.dequeue()
        count1 = 3
    if count2 == 0 and q2.size()>0:
        q2.dequeue()
        count2 = 2
    if q1.size() < 5 and Q.size() > 0:
        q1.enqueue(Q.dequeue())
    elif q2.size() < 5 and Q.size() > 0:
        q2.enqueue(Q.dequeue())
    if q1.size() > 0:
        count1 -= 1
    if q2.size() > 0:
        count2 -= 1
    print(i+1,Q,q1,q2)
