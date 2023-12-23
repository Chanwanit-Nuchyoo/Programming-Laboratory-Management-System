def math_operation(a,b):
    return(a+b-5)

astr,bstr,lrstr,rrstr = input("Enter input numbers and ranges: ").split()
a,b = int(astr),int(bstr)
lr,rr = int(lrstr),int(rrstr)
result = math_operation(a,b)

print('The result of an operation is:',result)
if lr<=result<=rr:
    print('Operation is in the range.')
else:
    print('Operation is out of range.')
      