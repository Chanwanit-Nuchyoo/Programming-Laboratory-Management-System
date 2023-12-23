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

class Stack:
    def __init__(self):
        self.items = []

    def push(self, value):
        self.items.append(value)

    def pop(self):
        return self.items.pop()

    def size(self):
        return len(self.items)

    def isEmpty(self):
        return self.items == []

def TENET(arr, z, q, team):
    cnt, s = 0, ""
    betray = 0
    for i in arr:
        if z.isEmpty():
            z.push(i)
        else:
            top = z.pop()
            if i != top or z.isEmpty():
                z.push(top)
                z.push(i)
            else:
                sec_top = z.pop()
                if i != sec_top:
                    z.push(sec_top)
                    z.push(top)
                    z.push(i)
                elif i == sec_top and team == "mirror":
                    q.enQ(i)
                    cnt += 1
                elif i == sec_top and team == "normal":
                    if not q.isEmpty():
                        front = q.deQ()
                        if front != i:
                            z.push(sec_top)
                            z.push(top)
                            z.push(front)
                            z.push(i)
                        else:
                            z.push(front)
                            cnt += 1
                            betray += 1
                    else:
                        cnt += 1
    while not z.isEmpty():
        s += z.pop()
    return cnt, s, betray

Q = Queue()
r, b = input('Enter Input (Normal, Mirror) : ').split()
cnt_b, ans_b, kf_b = TENET(b[::-1], Stack(), Q, "mirror")
cnt_r, ans_r, kf_r = TENET(r, Stack(), Q, "normal")
print("NORMAL :")
print("{0}\n{1}".format(len(ans_r), "Empty" if len(ans_r) == 0 else ans_r))
if (cnt_r - kf_r) > 0 or kf_r == 0:print("{0} Explosive(s) ! ! ! (NORMAL)".format(cnt_r - kf_r))
if kf_r >= 1: print("Failed Interrupted {0} Bomb(s)".format(kf_r))
print("-"*12, "MIRROR", "-"*12, sep='')
print(": RORRIM")
print("{0}\n{1}".format(len(ans_b), "ytpmE" if len(ans_b) == 0 else ans_b))
print("(RORRIM) ! ! ! (s)evisolpxE {0}".format(cnt_b))