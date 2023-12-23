class funString():
    def __init__(self,string = ""):
        self.string = string
    def __str__(self):
        return self.string

    def size(self) :
        return len(self.string)

    def changeSize(self):
        ans = ""
        for i in range(len(self.string)):
            if ord(self.string[i]) <= 90 and ord(self.string[i]) >= 65:
                ans += chr(ord(self.string[i]) + 32)
            elif ord(self.string[i]) >= 97 and ord(self.string[i]) <= 122:
                ans += chr(ord(self.string[i]) - 32)
            else :
                ans += self.string[i]
        self.string = ans
        return self.string

    def reverse(self):
        ans = ""
        for i in range(len(self.string)-1,-1,-1):
            ans += self.string[i]
        self.string = ans
        return self.string

    def deleteSame(self):
        ans = ""
        for ele in self.string:
            if ele not in ans :
                ans += ele
        self.string = ans
        return self.string


str1,str2 = input("Enter String and Number of Function : ").split()
res = funString(str1)
if str2 == "1" :
    print(res.size())
elif str2 == "2":
    print(res.changeSize())
elif str2 == "3" :
    print(res.reverse())
elif str2 == "4" :
    print(res.deleteSame())