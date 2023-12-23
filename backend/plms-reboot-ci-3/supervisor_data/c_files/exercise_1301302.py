def weirdSubtract(n,k):
	for i in range(k):
		n=n-1 if n%10 else n//10
	
	return n
n,s = input("Enter num and sub : ").split()

print(weirdSubtract(int(n),int(s)))