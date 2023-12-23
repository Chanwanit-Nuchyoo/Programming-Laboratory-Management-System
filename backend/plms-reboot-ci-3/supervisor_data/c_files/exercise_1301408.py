n = int(input("Sum from 1 to : "))
if n <= 0 :
    print("Input Error")
    quit()
i = 1
sum = 0
while i <= n :
    sum = sum + i
    i = i + 1
print("Sum from 1 to", n,"is",sum)