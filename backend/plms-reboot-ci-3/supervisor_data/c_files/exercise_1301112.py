class Node :     
        def __init__(self,data,next = None) :     #สร้างโหนดเพื่อเก็บข้อมูล
            self.data = data
            if next is None :
                self.next = None
            else :
                self.next = next

class LinkedList :
    
    def __init__(self):                        #สร้าง linked list ว่าง     
            self.header = Node(None,None)
            self.size = 0
            
    def __str__(self):                         #แสดงข้อมูลจากหัวไปหาง
        s = 'LinkedList data : '
        p = self.header.next
        while p != None :
            s += str(p.data) + ' '
            p = p.next
        return s

    def __len__(self) : return self.size       #ส่งค่าจำนวนสมาชิก

    def isEmpty(self) : return self.size == 0   #ตรวจสอบลิสต์ว่าง

    def indexOf(self,data) :		               # หา index ของข้อมูล data
        q = self.header.next
        for i in range(len(self)) :
            if q.data == data :
                return i
            q = q.next
        return -1 

    def isIn(self,data) :     #ส่งค่า True ถ้า linked list ว่าง, False ถ้าไม่ว่าง
        return self.indexOf(data) >= 0

    def nodeAt(self,i) :                      #หาตำแหน่งโหนดที่ index i
        p = self.header
        for j in range(-1,i) :
            p = p.next
        return p

    def append(self,data) :                    #เพิ่มข้อมูลต่อท้าย
        return self.insertAfter(len(self),data)

    def insertAfter(self,i,data) :            #เพิ่มข้อมูลหลังโหนด index i
        p = self.nodeAt(i-1)
        p.next = Node(data,p.next)
        self.size += 1

    def add(self,data) : 			     #เพิ่มข้อมูลแบบเรียงลำดับจากน้อยไปมาก
        if not self.isEmpty() :
            i = 0
            p = self.header.next
            for i in range(len(self)) :
                if data > p.data :
                    p = p.next
                    i += 1
                else :
                    self.insertAfter(i,data)
                    return
        self.insertAfter(len(self),data)
   
    def deleteAfter(self,i) :           	   #ลบโหนดหลัง index i       
        p = self.nodeAt(i)
        p.next = p.next.next
        self.size -= 1
        
    
    def deleteAfterData(self, data):
        p = self.header.next
        while p is not None:
            if p.data == data and p.next is not None:
                p.next = p.next.next
            p = p.next
            


def findMean(l) :
    sum = 0
    p = l.header.next
    for i in range(len(l)) :
        sum += p.data
        p = p.next
    print("Mean = %.2f" % (sum/len(l)))





class Queue:
    def __init__(self, q = None):
        if q == None:
            self.item = LinkedList()
        else:
            self.item = q

    def __str__(self) :
        s = 'Queue data : '
        st = str((self.item))
        s += str(st[18:])
        return s

    def __len__(self) :
        return len(self.item)

    def enQueue(self, data):
        self.item.append(data)

        
    def deQueue(self):
        if not self.item.isEmpty() :
            return self.item.deleteAfter(-1)
        

    def clear(self):
        for i in range(len(self)):
            self.deQueue()

    def isEmpty(self):
        return self.item.isEmpty()
    
rawdata = list(input("Enter number : ").split())
q = Queue()
for e in rawdata :
    q.enQueue(e)
print(q)
q.deQueue()
print(q)
q.deQueue()
print(q)
