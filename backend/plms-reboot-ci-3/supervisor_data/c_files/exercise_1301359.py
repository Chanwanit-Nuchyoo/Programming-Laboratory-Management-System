def calculateBMI(height, weight):
    h = float(height)/100
    bmi = float(weight)/(h**2)
    return bmi
    
def getInput():
    print(" *** BMI Calculation ***")
    return input("Enter height(cm) weight(kg) : ")
    
def bmiConclusion(bmi):    
    if bmi < 18.5:
        return "You're underweight."
    if bmi < 25:
        return "You're normal."
    if bmi < 30:
        return "You're overweight."
    if bmi < 35:
        return "You're obese."
    return "You're extremly obese."
    
height, weight = getInput().split()
bmi = calculateBMI(height, weight)
print("Your BMI is %.2f" %bmi)
print(bmiConclusion(bmi))
