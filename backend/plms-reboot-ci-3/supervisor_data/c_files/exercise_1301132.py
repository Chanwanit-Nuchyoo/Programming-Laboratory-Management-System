class Calculator :
    def __init__(self,x=0):
        self.value = x
    
    def __str__(self):
        return str(self.value)

    def __add__(self,other):
        x = self.value + other.value
        return x
    
    def __sub__(self,other):
        x = self.value - other.value
        return x
    
    def __mul__(self,other):
        x = self.value * other.value
        return x

    def __truediv__(self,other):
        x = self.value / other.value
        return x

x,y = input("Enter num1 num2 : ").split(",")
x,y = Calculator(int(x)),Calculator(int(y))
print(x+y,x-y,x*y,x/y,sep = "\n")
