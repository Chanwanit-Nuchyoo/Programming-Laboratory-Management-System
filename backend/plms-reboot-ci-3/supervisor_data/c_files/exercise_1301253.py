def bubble(l):
    for last in range(len(l)-1, 0,-1):# จาก last ind ถึง ind 0
        swaped = False
        x = None
        for i in range(last):
            if l[i] > l[i+1]:
                x = l[i]
                l[i], l[i+1] = l[i+1], l[i] #swap
                swaped = True
        if not swaped:
            print("last step :",l,"move["+str(x)+"]")
            break
        if last == 1:
            print("last step :",l,"move["+str(x)+"]")
        else:
            print(len(l)-last,"step :",l,"move["+str(x)+"]")

l = [int(e) for e in input("Enter Input : ").split()]
bubble(l)