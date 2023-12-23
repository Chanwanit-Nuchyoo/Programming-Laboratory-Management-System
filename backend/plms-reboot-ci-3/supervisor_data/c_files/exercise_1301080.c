print(" *** Combine 2 lists to a dictionary ***")
input = input("Enter 2 lists : ")
l1, l2 = input.split(',')
print(l1.split())
print(l2.split())

l1, l2 = l1.split(),l2.split()
dic = {}
for i in range(len(l1)):
    k, v = l1[i],l2[i]
    #print(l1[i],l2[i]) 
    dic.update({l1[i]:l2[i]})
print(dic)