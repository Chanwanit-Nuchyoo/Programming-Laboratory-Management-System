print(" *** Median Mean ***")
input = input("Enter numbers : ")
sum=0
list = []
for i in input.split():
    list.append(int(i))
    sum += int(i)
print("list = ",list)
l = len(list)
mean = sum/l
if mean == int(mean):
   print("Mean = ", int(mean))
else:
    print("Mean = %.2f"%mean)

list.sort()
print("sort list =",list)
if(l%2==0):
    median = (list[l//2]+list[(l//2)-1])/2
else:
    median = list[l//2]
if median == int(median):
   print("Median = ", int(median))
else:
    print("Median = %.2f"%median)