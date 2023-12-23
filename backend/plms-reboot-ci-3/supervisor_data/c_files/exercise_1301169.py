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
        return str(len(self.value))

Q = Queue()
ip = input("Enter Input : ").split(',')
for i in ip:
    if i[0] == 'E':
        Q.enqueue(i[2:])
        print("Add",Q.value[-1],"index is",Q.value.index(Q.value[-1]))
    elif i[0] == 'D':
        if not Q.isEmpty():
            a = Q.dequeue()
            print("Pop",a,"size in queue is",Q.size())
        else :
            print("-1")
    else:
        print("Invalid Input")

if not Q.isEmpty():
    print("Number in Queue is : ",Q)
else :
    print("Empty")