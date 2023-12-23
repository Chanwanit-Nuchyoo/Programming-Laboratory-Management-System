h,w = input("Enter your High and Weight : ").split(" ")
h = float(h)
BMI = (float(w)/(h*h))
if BMI < 18.50:
    print("Less Weight")
elif BMI < 23 :
    print("Normal Weight")
elif BMI < 25 :
    print("More than Normal Weight")
elif BMI < 30 :
    print("Getting Fat")
elif BMI >= 30 :
    print("Fat")