words = input("Enter some words: ").split()
out = ""
for i in range(len(words)):
    if i == 0:
        out += words[i].lower()
    else:
        out += words[i].capitalize()
print("lowerCamelCase:", out)
