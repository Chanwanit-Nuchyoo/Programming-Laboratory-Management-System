print(" *** Find least frequent word ***")
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
print("Least =", min_key,"=>",count[min_key])