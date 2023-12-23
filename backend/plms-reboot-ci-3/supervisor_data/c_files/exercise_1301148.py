def bmi():
    print(" *** BMI ***")
    w,h = input("Enter your weight(kg) and height(m) : ").split()
    bmi = float(w) / (float(h)*float(h))
    print("Your status is : ",end='')
    if bmi >= 40: print("Case III Obesity.")
    elif bmi >= 35: print("Case II Obesity.")
    elif bmi >= 30: print("Case I Obesity.")
    elif bmi >= 25: print("Overweight.")
    elif bmi >= 18.5: print("Normal weight.")
    else : print("Below normal weight.") 
    
   
bmi()