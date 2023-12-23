A = ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z')
N = int(input(" *** Create Tuple ***\nEnter a number : "))
for i in range(0, N):
    for j in range(0, i+1) :
        print(A[j], end = ' ')
    print()