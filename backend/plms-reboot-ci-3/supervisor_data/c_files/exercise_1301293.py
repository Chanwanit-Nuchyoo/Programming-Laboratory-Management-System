def Rshift(num,shift):
    return num >> shift

n,s = input("Enter number and shiftcount : ").split()
print(Rshift(int(n),int(s)))