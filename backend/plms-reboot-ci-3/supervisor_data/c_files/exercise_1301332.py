class Node:
    def __init__(self, value):
        self.value = value
        self.next = None
    def __str__(self):
        return str(self.value)

def createLL(LL):
    head = Node(LL[0])
    cur = head
    for i in range(1, len(LL)):
        cur.next = Node(LL[i])
        cur = cur.next
    return head

def printLL(head):
    s = str(head)
    cur = head.next
    while cur != None:
        s += " " + str(cur)
        cur = cur.next
    return s

def SIZE(head):
    cnt, cur = 0, head
    while cur != None:
        cnt, cur = cnt + 1, cur.next
    return cnt

def scarmble(head, b, r, size):
    bottomup, riffle = int((b / 100) * size), int((r / 100) * size)
    debottom, deriffle = size - bottomup, size - riffle
    prev, cur, cnt = head, head.next, 1
    while cur != None:
        if cnt == bottomup:
            prev.next = None
            new_head = cur
            while cur.next != None:
                cur = cur.next
            cur.next = head
            head = new_head
            break
        prev = cur
        cur = cur.next
        cnt += 1
    print("BottomUp {0:.3f} % : {1}".format(b, printLL(head)))
    prev, cur, cnt = head, head.next, 1
    while cur != None:
        if cnt == riffle:
            prev.next = None
            head_2 = cur
            if SIZE(head) >= SIZE(head_2):
                cur_1, cur_2 = head, head_2
                while cur_2 != None:
                    head_2 = cur_2.next
                    cur_2.next = cur_1.next
                    cur_1.next = cur_2
                    cur_1 = cur_1.next.next
                    cur_2 = head_2
            else:
                head_1 = head
                cur_1, cur_2 = head_1, head_2
                while cur_1 != None:
                    head_1 = cur_1.next
                    cur_1.next = cur_2
                    head_2 = cur_2.next
                    cur_2.next = head_1
                    cur_1 = head_1
                    cur_2 = head_2
                cur = head
                while cur.next != None:
                    cur = cur.next
                cur.next = cur_2
            break
        prev = cur
        cur = cur.next
        cnt += 1
    print("Riffle {0:.3f} % : {1}".format(r, printLL(head)))
    h1 = head
    h2 = h1.next
    cur1, cur2 = h1, h2
    if r <= 50:
        for i in range(1, riffle):
            if cur1 != None and cur1.next != None:
                cur1.next = cur2.next
                cur1 = cur2.next
            if cur2 != None and cur2.next != None:
                cur2.next = cur1.next
                cur2 = cur1.next
        cur = h1
        for i in range(1, riffle):
            cur = cur.next
        cur.next = h2
    else:
        for i in range(deriffle):
            if cur1 != None and cur1.next != None:
                cur1.next = cur2.next
                cur1 = cur2.next
            if cur2 != None and cur2.next != None:
                cur2.next = cur1.next
                cur2 = cur1.next
        cur = h2
        for i in range(1, deriffle):
            cur = cur.next
        cur.next = None
        cur1 = h1
        while cur1.next != None:
            cur1 = cur1.next
        cur1.next = h2

    print("Deriffle {0:.3f} % : {1}".format(r, printLL(head)))
    cur1,cnt = head,1
    while cnt < debottom:
        cur1 = cur1.next
        cnt += 1
    head2 = cur1.next
    cur1.next = None
    cur2 = head2
    while cur2.next != None:
        cur2 = cur2.next
    cur2.next = head
    head = head2
    print("Debottomup {0:.3f} % : {1}".format(b, printLL(head)))

inp1, inp2 = input('Enter Input : ').split('/')
print('-' * 50)
h = createLL(inp1.split())
for i in inp2.split('|'):
    print("Start : {0}".format(printLL(h)))
    k = i.split(',')
    if k[0][0] == "B" and k[1][0] == "R":
        scarmble(h, float(k[0][2:]), float(k[1][2:]), SIZE(h))
    elif k[0][0] == "R" and k[1][0] == "B":
        scarmble(h, float(k[1][2:]), float(k[0][2:]), SIZE(h))
    print('-' * 50)