print(" *** Show max/min key and their summation ***")
ins = input("Enter text : ")
count = dict()
for word in ins.split():
    #print(word)
    count[word] = count.get(word,0)+1
#print(count)
min_value=99
min_key = ''
#print(count.items())
for k,v in count.items():
    #print("key=",k,"value=",v)
    if (v<min_value):
        min_key= k
        min_value = v
#print(count[min_key])
max_value=0
max_key = ''
#print(count.items())
for k,v in count.items():
    #print("key=",k,"value=",v)
    if (v>max_value):
        max_key= k
        max_value = v
print(max_key+min_key, "sum =",count[max_key]+count[min_key])