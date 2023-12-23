def halfFreq():
    ls = [int(e) for e in input("Enter number end with (-1) : ").split()]
    lls = []
    minus_one_count=0
    for i in ls:
        if i == -1:
            minus_one_count += 1
            break
        lls.append(i)
    if minus_one_count==0:
        print("Invalid INPUT !!!")
        exit()
    a = set()
    b = dict()
    for i in lls:
        if i not in a:
            a.add(i)
            b[i] = 1
        else:
            b[i] += 1
    c = len(lls)/2
    found = 0
    for k, v in b.items():
        if v > c:
            print(k)
            found = 1
    if found == 0:
        print("Not found")

halfFreq()