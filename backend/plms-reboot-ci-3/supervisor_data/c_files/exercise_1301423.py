def odd_values_string(str): 
    result = "" 
    for i in range(len(str)): 
        if i % 2 != 0: 
            result = result + str[i] 
    return result 
            
print(" *** Remove ODD characters ***")
stringInput = input("Enter a string : ")
print("Even characters =",odd_values_string(stringInput))