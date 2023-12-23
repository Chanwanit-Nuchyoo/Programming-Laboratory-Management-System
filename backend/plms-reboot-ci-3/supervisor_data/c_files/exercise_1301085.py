def sumnumber():
    print(" *** Summation of each digit ***")
    num = input("Enter a positive number : ")
#    print(num)
    sumnum = 0
    for i in num:
        sumnum += int(i)
    print("Summation of each digit = ",sumnum)
  
    
sumnumber()