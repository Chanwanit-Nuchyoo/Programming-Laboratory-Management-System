class Rational():
    def __init__(self,n=1,d=1):
        self.numerator = n
        self.denominator = d

    def __str__(self):
        if self.denominator == 1 :
            return str(self.numerator)
        return str(self.numerator)+'/'+str(self.denominator)

    def __lt__(self,rhs):
        if (self.numerator*rhs.denominator < rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def _gt__(self,rhs):
        if (self.numerator*rhs.denominator > rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def __le__(self,rhs):
        if (self.numerator*rhs.denominator <= rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def __ge__(self,rhs):
        if (self.numerator*rhs.denominator >= rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def __eq__(self,rhs):
        if (self.numerator*rhs.denominator == rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def __ne__(self,rhs):
        if (self.numerator*rhs.denominator != rhs.numerator*self.denominator):
            return "TRUE"
        return "FALSE"

    def __add__(self,rhs):
        nu = self.numerator*rhs.denominator + rhs.numerator*self.denominator
        de = rhs.denominator*self.denominator
        gcd = self.gcd(nu,de)
        return Rational(nu//gcd,de//gcd)

    def __sub__(self,rhs):
        nu = self.numerator*rhs.denominator - rhs.numerator*self.denominator
        de = rhs.denominator*self.denominator
        gcd = self.gcd(nu,de)
        return Rational(nu//gcd,de//gcd)

    def __mul__(self,rhs):
        nu = self.numerator * rhs.numerator
        de = rhs.denominator*self.denominator
        gcd = self.gcd(nu,de)
        return Rational(nu//gcd,de//gcd)

    def __truediv__(self,rhs):
        nu = self.numerator*rhs.denominator
        de = self.denominator*rhs.numerator
        gcd = self.gcd(nu,de)
        return Rational(nu//gcd,de//gcd)
    
    def __div__(self,rhs):
        
        return "__div__"
    
    def __floordiv__(self,rhs):
        nu = self.numerator*rhs.denominator
        de = self.denominator*rhs.numerator
        result = nu/de
        
        return int(result)

    def gcd(self,a,b):
        while b:
            a, b = b, a%b
        return a

	#a,b,c,d = [int(e) for e in input().split()]


    
print(" *** Rational Calculator ***")
print(" *        A = n1/d1        *")
print(" *        B = n2/d2        *")
print(" ***************************\n")
str_input = input("Enter n1 d1 n2 d2 : ")
n1, d1, n2, d2 = [int(e) for e in str_input.split()]
A = Rational(n1,d1)     # A = n1/d1
B = Rational(n2,d2)     # B = n2/d2
C = Rational()          # C = 1/1      
print("A = ",A,"\tB= ",B,"\tC = ",C)

print("A < B ==> ",A<B)     # method __lt__
print("A > B ==> ",A>B)     # method __gt__
print("A <= B ==> ",A<=B)   # method __ge__
print("A >= B ==> ",A>=B)   # method __gt__
print("A == B ==> ",A==B)   # method __eq__
print("A != B ==> ",A!=B)   # method __ne__
print("A + B ==> ",A+B)     # method __add__
print("A - B ==> ",A-B)     # method __sub__
print("A * B ==> ",A*B)     # method __mul__
print("A / B ==> ",A/B)     # method __truediv__
print("A // B ==> ", A//B)   # method __truediv__
print("A + C ==> ",A+C)                         
