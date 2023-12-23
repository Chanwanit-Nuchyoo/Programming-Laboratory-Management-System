try:
    userInput = input("Enter 2 integers : ")
    a, b = userInput.split()
    a, b = int(a),int(b)
except:
    print("Invalid input !!!")
    quit()
sum = a+b
print(a,b,end=" ")
for i in range(5):
    c= a+b
    print(c,end=" ")
    a,b = b,c
    sum += c

print("\nsummation =",sum)