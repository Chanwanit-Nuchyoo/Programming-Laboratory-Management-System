# Find all combinations that satisfies given constraints
def findAllCombinations(A, elem, n):

    # if all elements are filled, print the solution
    if elem > n:
        print(A)
        return

    # try all possible combinations for element elem
    for i in range(2 * n):

        # if position i and (i+elem+1) are occupied not in the input
        if A[i] == -1 and (i + elem + 1) < 2 * n and A[i + elem + 1] == -1:

            # place elem at position i and (i+elem+1)
            A[i] = elem
            A[i + elem + 1] = elem

            # recur for next element
            findAllCombinations(A, elem + 1, n)

            # backtrack (remove elem from position i and (i+elem+1) )
            A[i] = -1
            A[i + elem + 1] = -1


if __name__ == '__main__':

    # given number
    print(" *** All combination 2xN ***")
    n = int(input("Enter number : "))

    # create a input of the size of given number with
    # all its elements initialized by -1
    A = [-1] * (2 * n)

    # start from element 1
    elem = 1
    print('Output :')
    findAllCombinations(A, elem, n)