def rank():
    print(" *** Rank score ***")
    ls = input("Enter ID and Score end with ID : ").split()
    #print(lsd)
    ls1 = ls[:-1]
    key = ls[-1]

    print(ls1)
    print(key)
    lsd1 = dict()
    lsd2 = dict()
    i = 0
    while i < len(ls1)//2:
        lsd1[ls[i*2]] = float(ls[i*2+1])
        lsd2[float(ls[i*2+1])] = ls[i*2]
        i += 1
    print(lsd1)
    s1 = sorted(lsd2)
    s2 = s1[-1::-1]
    if key in lsd1.keys():
        print(s2.index(lsd1[key])+1)
    else:
        print("Not Found")
    #input example
    #121 87.25 221 77.00 321 82.50 421 69.75 521 66.00 421
    #111 100 13 96 1234 96 555 99 2121 96 99 99 1234
    #429801 78 359124 89 902316 91.25 773842 45.75 264336

rank()