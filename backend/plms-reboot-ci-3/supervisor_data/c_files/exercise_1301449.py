sum = 0
numLst = list(map(int, input("Sum Number in List\nInput 5 Numbers : ").split()))
for iter in numLst :
    if iter % 2 == 1 :
        sum -= iter
    else :
        sum += iter
print("Sum is",sum)