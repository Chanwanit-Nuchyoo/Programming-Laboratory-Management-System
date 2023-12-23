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
    
    def __add__(self,b):
        return self.num + b.num + (self.num+b.num)//2
        


'''
a = MyInt(500)
b = MyInt(40)
print(a.toRoman())
print(b.toRoman())
print(a+b)
'''
print(" *** class MyInt ***")
a,b = input("Enter 2 number : ").split()
num1 = MyInt(int(a))
num2 = MyInt(int(b))
print(a,"convert to Roman :",num1.toRoman())
print(b,"convert to Roman :",num2.toRoman())
print(a,"+",b,"=",num1+num2)