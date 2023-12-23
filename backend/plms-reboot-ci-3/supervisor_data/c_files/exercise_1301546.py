print(" *** Twin Pyramid display ***")
num = input("Enter an integer : ")
num=int(num)
if num<3:
    print(f'The input "{num}" must greater than 2 !!!')
    quit()
count = 0
ch = '*'
for r in range(num):
    for c in range(2*num-1):
        if r+c >= num-1 and c-r <= num-1:
            # print(ch,end="")
            print('*',end="")
            count +=1
        else:
            print(f" ",end="")
    print(" | ",end="")
    for c in range(2*num-1):
        if r+c >= num-1 and c-r <= num-1:
            # print(ch,end="")
            print('*',end="")
            count +=1
        else:
            print(f" ",end="")
    print()
print(f"Total ({ch}) = {count}");