print(" *** Word Triangle ***")
text = input("Enter Word: ")
length = len(text)
for i in range(length) :
    for j in range(i+1) :
        if (text[j]==' '):
            print('_',end='')
        else:
            print(text[j], end='')
    print("")