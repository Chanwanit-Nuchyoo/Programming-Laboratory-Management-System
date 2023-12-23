print(" *** Word Triangle ***")
text = input("Enter Word: ")
for i in range(len(text)) :
    for j in range(i+1) :
        print(text[j], end='')
    print("")