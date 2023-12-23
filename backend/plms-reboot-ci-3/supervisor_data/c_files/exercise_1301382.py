try:
    userInput = input("Enter 2 integers : ")
    start, end = userInput.split()
    start,end = int(start),int(end)
except:
    print("Invalid input !!!")
    quit()
if start>end:
    start,end = end, start
if start%2!=0:
    start += 1
if end%2!=0:
    end -= 1
print(start,end="")
sum = start
for i in range(start+2,end+2,2):
    print("+"+str(i),end="")
    #print("i=",i)
    sum += i

print(" =",sum)