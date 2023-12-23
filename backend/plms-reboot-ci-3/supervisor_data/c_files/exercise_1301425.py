print(" *** Max Min ***")
input = input("Enter numbers : ")
sum=0
list = []
for i in input.split():
    list.append(int(i))
    sum += int(i)
print("list = ",list)
print("Max =",max(list))
print("Min =",min(list))