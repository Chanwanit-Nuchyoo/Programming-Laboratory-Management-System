print(" *** Hollow Square ***")
text = input("Enter an integer : ")
num = int(text)
for r in range(num):
    for c in range(num):
        if r==0:
            print('*',end="")
        elif c==0:
            print('*',end="")
        elif r==num-1:
            print('*',end="")
        elif c==num-1:
            print('*',end="")
        else:
            print(' ',end="")
    print()