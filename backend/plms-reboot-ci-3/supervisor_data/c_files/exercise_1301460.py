print(" *** Creating Dictionary ***")
ins = input("Enter text : ")
dict1 = dict()
list1 = ins.split()
i=0
l = len(list1)
#print("l=",l)
while i<l :
    #print (list1[i],list1[i+1])
    dict1[list1[i]]=list1[i+1]
    i += 2
    #print("i=",i)
print(dict1)