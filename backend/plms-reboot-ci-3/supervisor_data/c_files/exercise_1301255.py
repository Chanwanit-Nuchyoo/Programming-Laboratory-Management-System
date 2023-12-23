# Return minimum index 
def minIndex( a , i , j ): 
    if i == j: 
        return i 
    k = minIndex(a, i + 1, j) 
    return (i if a[i] < a[k] else k)
def maxIndex( a , i , j ): 
    if i == j: 
        return i 
    k = maxIndex(a, i + 1, j) 
    return (i if a[i] > a[k] else k) 

def recurSelectionSort(a, n, index = 0): 
    if index == n: 
        return -1
    k = maxIndex(a, index, n-1)
    if k != n-1: 
        a[k], a[n-1] = a[n-1], a[k]
        print("swap",a[k],"<->",a[n-1],":",a)
    recurSelectionSort(a, n-1) 
      
l = [int(e) for e in input("Enter Input : ").split()]
# Calling function 
recurSelectionSort(l, len(l) ) 
  
# printing sorted array 
print(l)