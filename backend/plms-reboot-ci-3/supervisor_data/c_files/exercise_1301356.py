print(" *** Grade Classification ***")
score = input("Enter your score : ")
score = float(score)
if score <0:
    print(score,"is invalid ! ! !")
elif score<50:
    print("Grade F")
elif score<55:
    print("Grade D")
elif score<60:
    print("Grade D+")
elif score<65:
    print("Grade C")
elif score<70:
    print("Grade C+")
elif score<75:
    print("Grade B")
elif score<80:
    print("Grade B+")
elif score<=100:
    print("Grade A")
else:
    print(score,"is invalid ! ! !")