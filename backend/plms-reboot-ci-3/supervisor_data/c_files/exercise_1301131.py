def character_mapping(txt):
    x = sorted(set(txt),key=txt.index)
    return list(map(x.index, txt))

str1 = input("Enter String : ")
print(character_mapping(str1))