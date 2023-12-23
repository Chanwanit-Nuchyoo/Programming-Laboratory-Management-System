class Stack:
    def __init__(self,x = None,max=None):
        if(x == None):
            self.item = []
            self.temp = []
            self.size = 0
        else:    
            self.item = x
            self.temp = []
            self.max = max
    def __str__(self):
        return str(self.item)
    def push(self,x):
        return self.item.append(x)
    def pop(self):
        return self.item.pop()
    def size(self):
        return len(self.item)
    def isFull(self):
        if(self.max >self.size()):
            return False
        else:
            return True
    def arrive(self,x):
        if(self.isFull()):
            print("car "+str(x)+" cannot arrive : Soi Full")
        elif(x in self.item):
            print("car "+str(x)+" already in soi")
        else:
            self.push(x)
            print("car "+str(x)+" arrive! : Add Car "+str(x))
    def depart(self,x):
        if(self.size() == 0):
            print("car "+str(x)+" cannot depart : Soi Empty")
        elif(x not in self.item):
            print("car "+str(x)+" cannot depart : Dont Have Car "+str(x))
        else:
            l = self.item.copy()
            for i in range(len(self.item)-1,-1,-1):
                if(self.item[i]==x):
                    l.pop()
                    r = len(self.temp)
                    for j in range(r):
                        l.append(self.temp.pop())
                    self.item = l
                    print("car "+str(x)+" depart ! : Car "+str(x)+" was remove")
                    break
                else:
                    self.temp.append(l.pop())
print("******** Parking Lot ********")
m,s,o,n = input("Enter max of car,car in soi,operation : ").split()
m,n = int(m),int(n)
if(s != '0'):
    s = list(s.split(","))
    for i in range(len(s)):
        s[i] = int(s[i])
else:
    s = []
x = Stack(s,m)
if(o == "arrive"):
    x.arrive(n)
elif(o == "depart"):
    x.depart(n)
print(x)    