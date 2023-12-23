def fact(n):
	if n <= 1:
		return 1
	return n * fact(n - 1)
inp = int(input('Enter Number : '))
print("{0}! = {1}".format(inp, fact(inp)))