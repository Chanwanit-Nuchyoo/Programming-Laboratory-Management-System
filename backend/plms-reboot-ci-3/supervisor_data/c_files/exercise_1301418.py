def checkPalindrome(temp) :
    for i in range(0, int(len(temp)/2)):
        if temp[i] != temp[len(temp)-i-1]:
            return "not palindrome"
    return "is palindrome"

text1, text2, text3 = input(" *** Palindrome Checker ***\nInput 3 word to check: ").split()

if len(text1) < 2 or len(text2) < 2 or len(text3) < 2 :
    print("Input Error")
    quit()
    
print(text1, checkPalindrome(text1))
print(text2, checkPalindrome(text2))
print(text3, checkPalindrome(text3))