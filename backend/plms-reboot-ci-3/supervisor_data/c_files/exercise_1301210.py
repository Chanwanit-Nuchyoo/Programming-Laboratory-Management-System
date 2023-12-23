def move(n,A,B,C,maxn):
    if n == 1:
        print("move",n,"from ", A[0] ,"to",C[0])
        a = searchI(A)
        c = searchI(C)
        if type(C[c]) == int:
            c -= 1
        C[c],A[a] = A[a],C[c]   
        print_m(maxn,A,B,C)
    else:
        move(n-1,A,C,B,maxn)
        print("move",n,"from ", A[0] ,"to",C[0])
        a = searchI(A)
        c = searchI(C)
        
        if type(C[c]) == int:
            c -= 1
        C[c],A[a] = A[a],C[c]  
        print_m(maxn,A,C,B)
        move(n-1,B,A,C,maxn)
def searchI(l,n=0):
    if len(l) <= n:
        return n-1
    if l[n] != "|" and str(l[n]) not in "ABC":
        return n
    else:
        return searchI(l,n+1)
def print_m(n,A,B,C):
    if n <= 0 :
        print("|  |  |")
        return 0
    x = print_m(n-1,A,B,C)
    if A[0] == "A" and B[0] == "B" and C[0] == "C":
        print("{0}  {1}  {2}".format(A[n] if A != ["A"] else "|", B[n] if B != ["B"] else "|", C[n] if C != ["C"] else "|"))
    else:
        if A[0] == "A" and C[0] == "B" and B[0] == "C":
            print("{0}  {1}  {2}".format(A[n] if A != ["A"] else "|", C[n] if C != ["B"] else "|", B[n] if B != ["C"] else "|"))
        elif B[0] == "A" and A[0] == "B" and C[0] == "C":
            print("{0}  {1}  {2}".format(B[n] if B != ["A"] else "|", A[n] if A != ["B"] else "|", C[n] if C != ["C"] else "|"))
        elif B[0] == "A" and C[0] == "B" and A[0] == "C":
            print("{0}  {1}  {2}".format(B[n] if B != ["A"] else "|", C[n] if C != ["B"] else "|", A[n] if A != ["C"] else "|"))
        elif C[0] == "A" and A[0] == "B" and B[0] == "C":
            print("{0}  {1}  {2}".format(C[n] if C != ["A"] else "|", A[n] if A != ["B"] else "|", B[n] if B != ["C"] else "|"))
        elif C[0] == "A" and B[0] == "B" and A[0] == "C":
            print("{0}  {1}  {2}".format(C[n] if C != ["A"] else "|", B[n] if B != ["B"] else "|", A[n] if A != ["C"] else "|"))
        else:
            print(A,B,C)
    return x+1
n = int(input("Enter Input : "))
A_l,B_l,C_l=list(range(1,n+1)),["|"]*n,["|"]*n
A_l.insert(0,'A')
B_l.insert(0,'B')
C_l.insert(0,'C')
print_m(n,A_l,B_l,C_l)
move(n,A_l,B_l,C_l,n)
