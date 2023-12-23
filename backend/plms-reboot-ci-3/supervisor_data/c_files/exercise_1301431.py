p, N = input("Enter p N : ").split()

try :

    p_int = int(p)
    N_int = int(N)

except :
    
    print("Input must be an integer !!!")
    quit()

ans = 0
for n in range(N_int) :

    ans += 1/(n+1)**p_int

print("Sum of the series = %f" %ans)