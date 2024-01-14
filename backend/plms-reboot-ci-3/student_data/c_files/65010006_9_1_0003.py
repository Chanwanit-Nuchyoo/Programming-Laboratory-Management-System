print(" *** Creating Dictionary ***")
inp = input("Enter text : ").split(" ")

dictionary = {}

for i in range(0, len(inp), 2):
    key = inp[i]
    value = inp[i+1] if i+1 < len(inp) else None
    dictionary[key] = value

print(dictionary)