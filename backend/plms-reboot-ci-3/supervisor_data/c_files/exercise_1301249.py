def natural_sum(n):
  if n < 2:
    print(n,end='')
    if n != num: 
        print(' + ',end='')
    else: 
        print(' = ',end='')
    return 1
  else:
    m = natural_sum(n-1)
    print(f'{n} ',end='')
    if n != num: 
        print('+ ',end='')
    else: 
        print('= ',end='')
      
    return n + m
    
global num
print(" *** Natural sum ***")
num = int(input("Enter number : ")) 
print("%.d" %(natural_sum(num)))