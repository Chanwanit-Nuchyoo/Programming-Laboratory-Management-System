def createList(ins):
    # print("List =",ins.split())
    return ins.split()
# end function

def createDict(ins):
    i = 0;
    dict = {};
    ins = ins.split()
    length = len(ins)
    while i<length:
        # print(i,ins[i],ins[i+1])
        dict[ins[i]] = ins[i+1]
        i += 2
    return dict
# end function
        
def createTuple(ins):
    i = 0;
    dict = {};
    ins = ins.split()
    length = len(ins)
    l1 = []
    while i<length:
        # print(i,ins[i],ins[i+1])
        tup = (ins[i], ins[i+1])
        l1.append(tup)
        i += 2
    return l1
# end function  



print(" *** Create list, Dictionary and list of coordinate ***")
ins = input("Enter data : ")
list = createList(ins)
print("list ==>",list)
dict = createDict(ins)
print("dictionary ==>",dict)
tup = createTuple(ins)
print("list of coordinate ==>",tup)