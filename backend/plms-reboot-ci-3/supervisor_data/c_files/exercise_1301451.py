numLst = list(map(int, input("Min Number in List\nInput Numbers : ").split()))
min = 99999
for i in numLst :
    if i < min :
        min = i
print("Min number in List is", min)