r, N = input("Enter r N : ").split()

try :

    r_int = int(r)
    N_int = int(N)

except :
    
    print("Input must be an integer !!!")
    quit()

ans = 0
for n in range(N_int) :
    
    ans += r_int**n

print("Sum of the series = %d" %ans)