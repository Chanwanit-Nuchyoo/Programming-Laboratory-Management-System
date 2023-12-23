print(" *** Quiz 3 item 2 ***")
text = input("Enter a number : ")
num = int(text)
for row in range(num):
    for col in range(num):
        if row>=col:
            print("#",end='')
        else:
            print(" ",end='')
    print()
for row in range(num-1):
    for col in range(num-1):
        if row+col<num-1:
            print("#",end='')
        else:
            print(" ",end='')
    print()




