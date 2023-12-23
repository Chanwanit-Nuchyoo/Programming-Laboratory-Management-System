def countLowerCase(str): 
    count = 0
    index = 0
    for ch in str: 
        if ch.islower():
            count += 1
    return count 
print(" *** Lower case counting ***")
stringInput = input("Enter a string : ")
print("lower characters =",countLowerCase(stringInput))