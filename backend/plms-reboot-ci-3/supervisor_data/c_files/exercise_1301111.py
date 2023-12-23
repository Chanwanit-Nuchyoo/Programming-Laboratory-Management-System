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
            
    def removeDup(self):             #นำข้อมูลตัวซ้ำออก
	  #เพิ่มเติม code ส่วนนี้   ข้อ 2.1 
       seen = set()
       i = 0
       p = self.header.next
       while p != None :
           if p.data not in seen :
               seen.add(p.data)
           else :
               self.deleteAfter(i-1)
               i -= 1
           i += 1
           p = p.next


def findMean(l) :
    sum = 0
    p = l.header.next
    for i in range(len(l)) :
        sum += p.data
        p = p.next
    print("Mean = %.2f" % (sum/len(l)))


num = list(input("Enter number : ").split())
lst = LinkedList()
for e in num :
    lst.append(int(e))
print(lst)
findMean(lst)

