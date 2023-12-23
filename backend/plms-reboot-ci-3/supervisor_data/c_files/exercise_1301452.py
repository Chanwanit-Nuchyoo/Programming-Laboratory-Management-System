numLst = list(map(int, input("Max Number in List\nInput Numbers : ").split()))
max = -99999
for i in numLst :
    if i > max :
        max = i
print("Maximum number in List is", max)