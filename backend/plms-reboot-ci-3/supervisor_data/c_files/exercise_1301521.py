print(" *** Kebab-case ***")
words = input("Enter some words: ").split()
out = ""
for i in range(len(words)):
    if i == len(words)-1:
        out += words[i].capitalize()
    else:
        out += words[i].capitalize() + "-"
print("Kebab-case:", out)