text = input(" *** Alphabet classification ***\nInput Sentence to count : ")
count1, count2 = 0, 0
for i in text :
    if i == 'a' or i == 'A' :
        count1 = count1 + 1
    elif i == 'e' or i == "E" :
        count1 = count1 + 1
    elif i == 'i' or i == "I" :
        count1 = count1 + 1
    elif i == 'o' or i == "O" :
        count1 = count1 + 1
    elif i == 'u' or i == "U" :
        count1 = count1 + 1
    else :
        count2 = count2 +1
print("\nVovel in this sentence is", count1)
print("Consonant in this sentence is", count2)