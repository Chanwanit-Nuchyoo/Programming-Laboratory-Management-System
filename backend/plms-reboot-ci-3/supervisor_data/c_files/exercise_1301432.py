a, N = input("Enter a N : ").split()

try :

    a_int = int(a)
    N_int = int(N)

except :
    
    print("Input must be an integer !!!")
    quit()

ans = 0
for n in range(N_int) :

    ans += a_int/(n+1)

print("Sum of the series = %f" %ans)