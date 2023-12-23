print(" *** Find most frequent word ***")
ins = input("Enter text : ")
count = dict()
for word in ins.split():
    #print(word)
    count[word] = count.get(word,0)+1
#print(count)
max_value=0
max_key = ''
#print(count.items())
for k,v in count.items():
    #print("key=",k,"value=",v)
    if (v>max_value):
        max_key= k
        max_value = v
print("Max =",max_key,"==>",count[max_key])