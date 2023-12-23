print('*** Perimeter of a Triangle ***')
s1, s2, s3 = input('Enter first, second and third sides of a Triangle: ').split()
s1, s2, s3 = int(s1), int(s2), int(s3)
perim = s1 + s2 + s3
print("Perimeter of a Triangle = %.2f" %perim)