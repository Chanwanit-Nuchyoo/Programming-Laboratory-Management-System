def perfectNumber():
    print(" *** Perfect Number Verification ***")
    ls = []
    num = int(input("Enter number : "))
    sumfactor = 0
    if num > 0:
        for i in range(1, num):
            if num % i == 0:
                sumfactor += i
                ls.append(i)     
        if sumfactor == num:
            	print(num, "is a PERFECT NUMBER.")
        else:
            	print(num, "is NOT a perfect number.")
        print("Factors :",ls)
    else:
        print("Only positive number !!!")
perfectNumber()