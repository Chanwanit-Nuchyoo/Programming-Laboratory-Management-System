print(" *** Show Hello ***")
n = int(input("How many time you want to print Hello : "))
if n <= 0 :
    print("Input Error")
    quit()
for i in range(n) :
    print("Hello ", end='')