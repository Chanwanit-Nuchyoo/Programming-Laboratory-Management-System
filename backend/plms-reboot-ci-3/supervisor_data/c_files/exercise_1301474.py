def key_exist(key):
    if key in d:
        return True
    else:
        return False

d = {'chess': 1, 'butter': 2, 'ant': 3, 'dip': 4, 'salt': 5, 'sugar': 6, 'elephant':7}
print("Yes, key is exist.") if key_exist(input("Input key to check : ")) else print("No, key is not exist.")