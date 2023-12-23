n = int(input("How big is the triangle : "))
if n < 0 :
    print("Input Error")
    quit()
for i in range(n) :
    for j in range(i+1) :
        print("*",end='')
    print("")