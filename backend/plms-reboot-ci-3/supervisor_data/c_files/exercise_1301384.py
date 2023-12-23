try:
    userInput = input("Enter 2 integers : ")
    start, end = userInput.split()
    start,end = int(start),int(end)
except:
    print("Invalid input !!!")
    quit()
if start>end:
    start,end = end, start
print(start,end="")
sum = 0
for i in range(end-start):
    print("+"+str(i+start+1),end="")
    sum += i+start

print(" =",sum+end)