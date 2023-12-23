print(" *** String or Number ***")
text = input("Enter something : ")
try:
    num = float(text)
    print(f'Number / 2 = {num/2}')
except :
    print("String = ",end="")
    print(text*3,)