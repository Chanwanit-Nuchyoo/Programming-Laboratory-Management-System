input = input("Enter 3-digit number : ")
a = int(input)
unit = a%10
tenth = a//10%10
hundredth = a//100
sum = unit + tenth + hundredth

print(f"\nnumber = {a} {type(a)} ==> ",end="");
print(f"{hundredth} {tenth} {unit}")
print(f'Sum => {sum} ',end="")
if sum%2 == 0 :
    print("=> Even.")
else:
    print("=> Odd.")