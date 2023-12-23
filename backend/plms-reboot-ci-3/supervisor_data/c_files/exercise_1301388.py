print('*** Area of Triangle ***')
width, length = input('Enter width and height of Triangle: ').split()
width, length = float(width), float(length)
TriaArea = (width * length) / 2
print("Area of Triangle = %.2f" %TriaArea)