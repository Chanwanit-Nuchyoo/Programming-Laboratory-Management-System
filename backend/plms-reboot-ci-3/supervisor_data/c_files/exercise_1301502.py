print(' *** Find number of lines for specific word ***')
filename,word = input("Enter file name and word : ").split()
f = open(filename)
word_count = 0
line_count = 0
for l in f:
    line_count += 1
    if word in l:
	    word_count += 1
print(f'Number of lines having "{word}" => {word_count}')
print(f'Total lines => {line_count}')