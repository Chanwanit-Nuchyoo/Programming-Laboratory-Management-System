class Queue:
    def __init__(self):
        self.items = []

    def enQ(self, value):
        self.items.append(value)

    def deQ(self):
        return self.items.pop(0)

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []
    def getStr(self):
        ans = []
        for e in self.items:
            a,l = e.split(":")
            ans.append(act[int(a)]+":"+location[int(l)])
        return str(', '.join(ans))    
    def __str__(self):
        return str(', '.join(self.items))
act = {0 : "Eat",1 : "Game",2 : "Learn",3 : "Movie"}
location = {0 : "Res.",1 : "ClassR.",2 : "SuperM.",3 : "Home"}
Qme = Queue()
Qyou = Queue()
score = 0
n = input('Enter Input : ').split(',')
for e in n:
    me,you = e.split(" ")
    Qme.enQ(me)
    Qyou.enQ(you)
print("My   Queue =",Qme)
print("Your Queue =",Qyou)
print("My   Activity:Location =",Qme.getStr())
print("Your Activity:Location =",Qyou.getStr())
while(not Qme.isEmpty() and not Qyou.isEmpty()):
    me,you = Qme.deQ(),Qyou.deQ()
    if me == you:
        score = score+4
    elif me.split(":")[1] == you.split(":")[1]:
        score = score+2
    elif me.split(":")[0] == you.split(":")[0]:
        score = score+1
    else:
        score = score - 5
if score >= 7:
    print("Yes! You're my love! : Score is "+str(score)+".")
elif score > 0:
    print("Umm.. It's complicated relationship! : Score is "+str(score)+".")
else:
    print("No! We're just friends. : Score is "+str(score)+".")