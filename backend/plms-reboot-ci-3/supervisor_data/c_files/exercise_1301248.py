def harmonic_sum(n):
  if n < 2:
    print(n,end='')
    if n != num: 
        print(' + ',end='')
    else: 
        print(' = ',end='')
    return 1
  else:
    m = harmonic_sum(n-1)
    print(f'1/{n} ',end='')
    if n != num: 
        print('+ ',end='')
    else: 
        print('= ',end='')
      
    return (1 / n) + m
    
global num
print(" *** Harmonic sum ***")
num = int(input("Enter number of terms : ")) 
print("%.8f" %(harmonic_sum(num)))
