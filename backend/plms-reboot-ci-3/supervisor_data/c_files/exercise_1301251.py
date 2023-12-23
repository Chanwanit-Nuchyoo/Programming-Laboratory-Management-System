# Find all binary strings that can be formed from given wildcard pattern
def printAllCombinations(pattern, i=0):

    if i == len(pattern):
        print(''.join(pattern))
        return

    # if the current character is '?'
    if pattern[i] == '_':
        for ch in "01":

            # replace '_' with 0 and 1
            pattern[i] = ch

            # recur for the remaining pattern
            printAllCombinations(pattern, i + 1)

            # backtrack
            pattern[i] = '_'

    else:
        # if the current character is 0 or 1, ignore it and
        # recur for the remaining pattern
        printAllCombinations(pattern, i + 1)


if __name__ == '__main__':
    
    #pattern = "1_11_00_1_"
    print(" *** All binary number ***")
    pattern = str(input("Enter Binary number ( _ as wildcard) : "))
    printAllCombinations(list(pattern))