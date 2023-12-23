print('*** Area of Trapezoid ***')
b1, b2, h = input('Enter values for bases (B1, B2) and height : ').split()
b1, b2, h = int(b1), int(b2), int(h)
TrapArea = ((b1 + b2) * h) / 2
print("Area of Trapezoid = %.2f" %TrapArea)