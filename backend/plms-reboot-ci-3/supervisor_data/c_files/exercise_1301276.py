count = 0
def shell_sort(arr): 
  
    global count
    n = len(arr) 
    inc = [3,1]
  
    for gap in inc:
        for i in range(gap,n): 
            temp = arr[i] 
            j = i 
            #count += 1
            while  j >= gap and arr[j-gap] > temp: 
                arr[j] = arr[j-gap] 
                j -= gap 
                count += 1
            if j - gap >= 0:
                count += 1
  
            arr[j] = temp 
       
        

print(" *** Shell sort ***")    
input_string = input("Enter some numbers : ")
A=[]
for n in input_string.split():
	A.append(int(n))
shell_sort(A)
print()
print(A)
print("Data comparison = ", count)