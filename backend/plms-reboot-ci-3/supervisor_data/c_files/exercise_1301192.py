def fibo(n):
	if 1 <= n <= 2:
		return 1
	return fibo(n - 1) + fibo(n - 2)
inp = int(input('Enter Number : '))
print("fibo({0}) = {1}".format(inp, fibo(inp)))