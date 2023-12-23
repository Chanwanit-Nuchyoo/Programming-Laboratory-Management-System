def harmonic_sum(n):
    sum = 0
    for i in range(n):
        if i==0:
            print('1 + ',end='')
        elif i==n-1:
            print(f'1/{i+1} = ',end='')
        else:
            print(f'1/{i+1} + ',end='')
        sum += 1/(i+1)
      
    return sum
    

print(" *** Harmonic sum ***")
num = int(input("Enter number of terms : ")) 
print(f'{harmonic_sum(num):0.4f}')