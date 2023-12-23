'''
 * กลุ่มที่  : 22010003
 * 65010851 ภูมิพัฒน์ บุญชื่น
 * chapter : 4	item : 3	ครั้งที่ : 0001
 * Assigned : Tuesday 23rd of August 2022 10:08:40 PM --> Submission : Friday 26th of August 2022 06:47:39 PM	
 * Elapsed time : 4118 minutes.
 * filename : ch4_3.py
'''
def calculateBMI(height, weight):
    # put your code below
    height=float(height)
    weight=float(weight)
    height=height/100
    BMI=weight/(height*height)
    return BMI

def getInput():
    # put your code below
    print(" *** BMI Calculation ***")
    hw=input("Enter height(cm) weight(kg) : ")
    return hw

def bmiConclusion(bmi):    
    # put your code below
    if(bmi>=35):
        return "You're extremly obese."
    elif(bmi>=30) :
        return "You're obese."
    elif(bmi>=25):
        return "You're overweight."
    elif(bmi>=18.5):
        return "You're normal."
    elif(bmi<18.5):
        return "You're underweight."
    

height, weight = getInput().split()
bmi = calculateBMI(height, weight)
print("Your BMI is %.2f" %bmi)
print(bmiConclusion(bmi))
