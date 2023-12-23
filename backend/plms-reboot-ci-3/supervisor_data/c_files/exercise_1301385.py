my_dict = {'Apple':100,'Mango':54,'Banana':247,'Guava':10,'Melon':130,'meLon':44,'ApplE':35, 'BaNaNa':30}
#print(my_dict)
print(" *** Find quantity of stock fruit ***")
for key in my_dict:
    print(key,"=>",my_dict[key])
ins = input("Enter fruit : ")
qty = 0
for tup in my_dict.items() :
    
    (k,v) = tup
    if k.title() == ins.title() :
        qty += v
        print(tup)
    # print(k,'==>',v)
    # print(type(k))
    # k1 = (k[0].title(),k[1])
    # print(k1)
print(ins.title(),'=',qty)