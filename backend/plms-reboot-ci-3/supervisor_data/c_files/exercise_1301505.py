print(" *** 30% of Number ***")
str = input("Enter a number : ")
print()
print(f'The number = {str} {type(str)}')
numberInt = int(str)
print(f'The number = {numberInt} {type(numberInt)}')
numberFloat = float(str)
print(f'The number = {numberFloat} {type(numberFloat)}')
print(f'30 % = {numberFloat*0.3:.5f}')
print(f'30 % = {numberFloat*0.3:.3f}')
print(f'30 % = {numberFloat*0.3:.1f}')
