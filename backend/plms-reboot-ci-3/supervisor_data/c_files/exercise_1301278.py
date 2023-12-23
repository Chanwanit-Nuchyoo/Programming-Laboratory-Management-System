count = 0
def insertion_sort(A): 
  
    global count
    n = len(A) 
    
   
    for index in range(1, n): 
        value = A[index]
        i = index -1
        while i>=0:
            count += 1
            if value < A[i]:
                A[i+1] = A[i]
                A[i] = value
                i -= 1
            else:
                break
            
    
        

print(" *** Insertion sort ***")    
input_string = input("Enter some numbers : ")
A=[]
for n in input_string.split():
	A.append(int(n))
insertion_sort(A)
print()
print(A)
print("Data comparison = ", count)