class MyInt:
    def __init__(self,n):
        self.num = n
        
    def toRoman(self):
        num = self.num
        val = [
            1000, 900, 500, 400,
            100, 90, 50, 40,
            10, 9, 5, 4,
            1
            ]
        syb = [
            "M", "CM", "D", "CD",
            "C", "XC", "L", "XL",
            "X", "IX", "V", "IV",
            "I"
            ]
        roman_num = ''
        i = 0
        while  num > 0:
            for _ in range(num // val[i]):
                roman_num += syb[i]
                num -= val[i]
            i += 1
        return roman_num
    
    def isPrime(self):
        nn = self.num
        if nn <= 1:
            return False
        for i in range(2, nn):
            if nn % i == 0:
                return False
        return True

    def _isPrime(self,i):
        nn = i
        if nn <= 1:
            return False
        for i in range(2, nn):
            if nn % i == 0:
                return False
        return True

    def showPrime(self):
        if self.num <= 1:
            return "!!!A prime number is a natural number greater than 1"
        rs = ""
        for i in range(self.num+1):
            if self._isPrime(i):
                rs += str(i)+' '
        return rs
    
    def __add__(self,b):
        return self.num + b.num + (self.num+b.num)//2
        
    
    def __sub__(self,b):
        return self.num - b.num//2

print(" *** class MyInt ***")
a,b = input("Enter 2 number : ").split()
num1 = MyInt(int(a))
num2 = MyInt(int(b))
print(a,"isPrime :",num1.isPrime())
print(b,"isPrime :",num2.isPrime())
print("Prime number between 2 and",a,":",num1.showPrime())
print("Prime number between 2 and",b,":",num2.showPrime())
print(a,"-",b,"=",num1-num2)