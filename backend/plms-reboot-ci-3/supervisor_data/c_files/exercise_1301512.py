print(" *** Pyramid / Cone display ***")
str = input("Enter height : ")
num = int(str)
if num<3:
    print(f'The input "{num}" must greater than 2 !!!')
    quit()
count=0
ch = '*'
for r in range(num):
    for c in range(2*num-1):
        if r+c >= num-1 and c-r <= num-1:
            # print(ch,end="")
            print(ch,end="")
            count +=1
        else:
            print(f" ",end="")
    print(" | ",end="")
    for c in range(2*num-1):
        if c>=r :
            if r+c < 2*num-1:
                print(ch,end='')
                count +=1
            else:
                print(" ",end='')
        else:
            print(" ",end='')
            
    print()
print(f"Total({ch}) = {count}")