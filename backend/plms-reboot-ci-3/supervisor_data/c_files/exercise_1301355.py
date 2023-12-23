print(" *** Integer type and odd even ***")
num = int(input("Enter any number : ")) 
if num == 0: 
    print(num,"is zero.") 
elif num < 0: 
    print(num,"is negative.") 
elif num > 0: 
    print(num,"is positive.")
    
if num%2==0:
    print(num,"is even.")
else:
    print(num,"is odd.")