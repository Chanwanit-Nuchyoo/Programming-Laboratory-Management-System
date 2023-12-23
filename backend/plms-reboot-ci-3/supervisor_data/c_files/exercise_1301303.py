def hbd(age):
    return "saimai is just {}, in base {}!".format(20 + age%2, age//2)
year = input("Enter year : ")
print(hbd(int(year)))