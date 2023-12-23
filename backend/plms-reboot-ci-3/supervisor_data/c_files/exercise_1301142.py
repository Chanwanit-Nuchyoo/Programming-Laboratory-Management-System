def drawrac():
    r = 0
    c = 0
    num = 0
    num = int(input("Enter a positive number : "))
    if num<=0 :
        print(f"{num} is too low.")
        return
    elif num>15:
        print(f"{num} is too high.")
        return
    
    for r in range(num) :
      for c in range(num) :
            if (r== 0) :
                print("%X " %(c+1),end='')
            elif (r == num-1) :
                if (c == 0) :
                    print("%X " %(num-c),end='')
                else :
                    print("%X " %(c),end='')
            elif (c==0) :
                print("%X " %(r+1),end='')
            elif (c==num-1) :
                print("%X " %(r),end='')
            else : 
                print("  ",end='')
      print()

drawrac()