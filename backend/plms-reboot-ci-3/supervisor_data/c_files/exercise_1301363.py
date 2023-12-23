def adder(num1, num2):
    try:
        num1,num2 = float(num1),float(num2)
    except:
        print("num1 or num2 is NOT VALID !!!")
        quit()
    if num1==int(num1) and num2==int(num2):
        return int(num1+num2)
    
        
    return num1+num2

print(" **** Adder Function ***")
num1, num2 = input('Enter 2 numbers: ').split()
result = adder(num1, num2)  # use adder() function here
# f-string(เอฟสตริง) คือการสร้าง string จากตัวแปร
# โดยจะนำค่าของตัวแปร มาแทนที่ วงเล็บปีกกา (curly brace)
fstring = f"{num1} + {num2} = {result}"
print(fstring)  # show output like the examples