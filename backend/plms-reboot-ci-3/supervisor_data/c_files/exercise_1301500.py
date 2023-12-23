print(' *** Find startswith lines ***')
filename,word = input("Enter file name : ").split()
f = open(filename)
line_count = 0
word_count = 0
for l in f:
    line_count += 1
    if l.startswith(word):
	    word_count += 1
print(f'Total lines : {line_count}')
print(f"""The number of lines staring with "{word}" is {word_count}""")