def palindrome(word):
    if len(word) <= 1:
        return True
    return False if word[0] != word[-1] else palindrome(word[1:-1])
inp = input('Enter Input : ')
tmp = palindrome(inp)
print("'{0}' is {1}".format(inp, "palindrome" if tmp == True else "not palindrome"))
