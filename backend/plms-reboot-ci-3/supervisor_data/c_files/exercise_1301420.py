words = input("Enter some words: ").split()
out = ""
for i in range(len(words)):
    if i == len(words)-1:
        out += words[i].lower()
    else:
        out += words[i].lower() + "-"
print("Kebab-case:", out)
