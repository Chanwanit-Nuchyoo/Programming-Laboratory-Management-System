print(" *** Sequence Verification ***")
inp = [int(i) for i in input('Enter Input : ').split()]

chk1 = inp.copy()
chk2 = inp.copy()
# print("inp",inp)
# print("chk1",chk1)
# print("chk2",chk2)
chk1.sort()
chk2.sort(reverse=True)
# print("chk1-2",chk1)
# print("chk2-2",chk2)
if (inp == chk1):
    print("Ascending sequence !!!")
elif (inp == chk2):
    print("Descending sequence !!!")
else:
    print("Neither ascending or descending sequence !!!")