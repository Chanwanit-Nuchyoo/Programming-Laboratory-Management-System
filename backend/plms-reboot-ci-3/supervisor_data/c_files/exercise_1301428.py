print(" *** Find word start with character ***")
colorList = ['yellow', 'red', 'green', 'black', 'brown', 'grey']
print(colorList)
char = input('Enter your character : ') 
result = list() 
for i in colorList: 
    #print(i)
    if i.startswith(char): 
        result.append(i) 
        #print("Adding...")
if len(result) == 0: 
    print ("There is no element start with '%s'"%char) 
else: 
    print(result)