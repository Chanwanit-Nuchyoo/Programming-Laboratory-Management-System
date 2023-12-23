'''
 * กลุ่มที่  : 20010101
 * 62010293 ณัฐวุฒิ ครองอารีธรรม
 * chapter : 15 item : 4        ครั้งที่ : 0006
 * Assigned : Friday 21st of August 2020 02:08:22 PM --> Submission : Friday 21st of August 2020 04:35:59 PM
 * Elapsed time : 147 minutes.
 * filename : LAB1.PY
'''
print('*** String Rotation ***')
a,b = input('Enter 2 strings : ').split(' ')
c = list(a)
d = list(b)
state1 = 0
state2 = 0
check = True
x=1


while x!=0 and check == True :
    for i in range(len(c),0,-1):
        if state1 == 2 :
            state1 = 0
            break
        else :
            c.pop()
            c.insert(0,i)
            state1 = state1+1
    for i in b:
        if state2 == 3 :
            state2 = 0
            break
        else :
            d.remove(i)
            d.extend(i)
            state2 = state2+1

    print(x,end=" ")
    for i in c:
        print(i,end="")