def bon(w):
	return [(ord(w[i])-96)*4 for i in range(len(w)-1) if w[i] == w[i+1]][0]
secretCode = input("Enter secret code : ")
print(bon(secretCode))