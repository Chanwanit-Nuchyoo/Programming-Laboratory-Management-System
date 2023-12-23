print("*** multiplication or sum ***")
num1,num2 = input("Enter num1 num2 : ").split()
product = int(num1) * int(num2)
if product <= 1000:
	print("The result is",product)
else:
	print("The result is",int(num1) + int(num2))