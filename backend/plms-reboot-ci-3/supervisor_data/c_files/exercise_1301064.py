try:
    n = int(input("Sum from 1 to : "))
except:
    print("Invalid input !!!")
    quit()
if n <= 0 :
    print("Input Error")
    quit()
   
i = 1
sum = 1
n -= 1
print(i,end="")
while i <= n :
    
    i = i + 1
    sum = sum + i
    str1 = "+"+str(i)
    print(str1,end="")
print(" =",sum)