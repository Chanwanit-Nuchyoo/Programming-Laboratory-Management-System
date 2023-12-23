count = 0
def bubble_sort(n):
    length = len(n)
    global count
    for i in range(length):
        swap = False
        for j in range(length-i-1):
            #print("i=",i," j=",j)
            count = count+1
            if n[j] > n[j+1]:
                n[j], n[j+1] = n[j+1], n[j]
                swap = True
        if not swap:
            break
        

print(" *** Bubble sort ***")    
input_string = input("Enter some numbers : ")
A=[]
for n in input_string.split():
	A.append(int(n))
bubble_sort(A)
print()
print(A)
print("Data comparison =", count)