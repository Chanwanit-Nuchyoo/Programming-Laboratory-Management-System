def recitemulti():
    
    print(" *** Recite the multiplication table ***")
    child = []
    index = 0
    tmp = []
    lsa = input("Enter pattern for child 1 to 3 (-1 for sep) : ").split()
    for e in lsa:
        if e != '-1':
            tmp.append(int(e))
        else:
            print(f'\nPattern for child {index+1} : ',end ='')
            for e in tmp : print(f'{e} ',end='')
            index += 1
            child.append(tmp)
            tmp = []
    


    #print(child[0],child[1],child[2])
    #print(len(child[0]),len(child[1]),len(child[2]))
    # child1 = [e for e in input("Enter for child 1 : ").split()]
    # child2 = [e for e in input("Enter for child 2 : ").split()]
    # child3 = [e for e in input("Enter for child 3 : ").split()]
    
    # 2 3 4 5 6 7 8 9 11 12
    # 12 11 9 8 7 6 5 4 3 2 
    # 2 12 3 11 4 10 5 9 6 8 7
    #child1 = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    #child2 = [0, 0, 0, 5, 3, 3, 3, 5, 4, 3, 2]
    #child3 = [2, 3, 2, 5, 3, 3, 4, 4, 4, 4, 5]
    print()
    i = 0
    while not (child[0][i%len(child[0])] == child[1][i%len(child[1])] == child[2][i%len(child[2])]):
        #print('child1',child[0][i%len(child[0])],
        #      'child2',child[1][i%len(child[1])],
        #      'child3',child[2][i%len(child[2])],sep = ' ')
        i += 1
        if i > 365:
            print("This year they never recite same multiplication table !!!")
            break
    else:    
        print("They recite same multiplication table in",i+1,"days")

    
recitemulti()