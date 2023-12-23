print(" *** Adding number ***")
words = input('Enter your words : ') 
i=1
newWords =[]
for word in words.split(): 
    #print(i)
    newWords.append(word+str(i))
    i +=1
print (newWords) 
for w in newWords:
	print(w,end=" ")